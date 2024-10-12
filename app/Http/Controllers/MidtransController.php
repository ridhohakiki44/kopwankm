<?php

namespace App\Http\Controllers;

use App\Models\Installment;
use App\Models\PaymentSession;
use App\Models\Saving;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Notification;
use Midtrans\Snap;

class MidtransController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function showPaymentPage()
    {
        $user = auth()->user();
        $currentMonth = now()->startOfMonth();

        // Ambil simpanan yang belum dibayar
        $savings = Saving::where('user_id', $user->id)
                        ->where('status', 'belum bayar')
                        ->get();

        // Ambil angsuran yang belum dibayar
        $installments = Installment::whereRelation('loan', 'user_id', $user->id)
                            ->where('status', 'belum bayar')
                            ->where(function($query) use ($currentMonth) {
                                $query->where('jatuh_tempo', '<', $currentMonth)  // Bulan sebelumnya
                                      ->orWhere(function ($query) use ($currentMonth) {
                                          $query->whereMonth('jatuh_tempo', '=', $currentMonth->month)  // Bulan ini
                                                ->whereYear('jatuh_tempo', '=', $currentMonth->year);   // Tahun ini
                                      });
                            })
                            ->get();

        $savingLateFee = null;
        foreach ($savings as $saving) {
            if ($saving->jenis_simpanan === 'wajib') {
                $savingPaymentDate = Carbon::now();
                $savingDueDate = Carbon::parse($saving->created_at);
            
                $savingLateFee = $this->calculateLateFee($savingDueDate, $savingPaymentDate);
                $saving->denda = $savingLateFee;
                $saving->save();
            }
        }
        
        $installmentLateFee = null;
        foreach ($installments as $installment) {
            $installmentPaymentDate = Carbon::now();
            $installmentDueDate = Carbon::parse($installment->jatuh_tempo);
        
            $installmentLateFee = $this->calculateLateFee($installmentDueDate, $installmentPaymentDate);
            $installment->denda = $installmentLateFee;
            $installment->save();
        }

        // Ambil pembayaran yang pending dari tabel payment_sessions
        $pendingPayments = PaymentSession::where('user_id', $user->id)
                                         ->where('status', 'pending')
                                         ->get();

        return view('payments.index', compact('savings', 'installments', 'savingLateFee', 'installmentLateFee', 'pendingPayments'));
    }

    public function processPayment(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'savings' => 'array',
            'savings.*' => 'exists:savings,id',
            'installments' => 'array',
            'installments.*' => 'exists:installments,id',
        ]);

        $user = auth()->user();

        // Ambil simpanan yang dipilih
        $savings = Saving::whereIn('id', $request->savings ?? [])->where('user_id', $user->id)->get();
        // Ambil angsuran yang dipilih
        $installments = Installment::whereIn('id', $request->installments ?? [])->whereRelation('loan', 'user_id', $user->id)->get();

        // Periksa jika data kosong
        if ($savings->isEmpty() && $installments->isEmpty()) {
            return redirect()->route('payments.index')->withErrors('Tidak ada data yang dipilih untuk dibayar.');
        }

        // Hitung total pembayaran termasuk denda
        $totalAmount = $savings->sum(function($saving) {
            return $saving->jumlah + $saving->denda;
        }) + $installments->sum(function($installment) {
            return $installment->jumlah + $installment->denda;
        });

        // Menyiapkan item details
        $itemDetails = collect($savings)->map(function($saving) {
            return [
                'id' => 'saving-'.$saving->id,
                'price' => $saving->jumlah + $saving->denda,
                'quantity' => 1,
                'name' => 'Simpanan '.$saving->jenis_simpanan,
            ];
        })->merge($installments->map(function($installment) {
            return [
                'id' => 'installment-'.$installment->id,
                'price' => $installment->jumlah + $installment->denda,
                'quantity' => 1,
                'name' => 'Angsuran Pinjaman',
            ];
        }))->toArray();

        // Membuat order_id dengan format uniqid-sid-iid
        $orderIdParts = collect($savings)->map(function($saving) {
            return 's'.$saving->id;
        })->merge($installments->map(function($installment) {
            return 'i'.$installment->id;
        }))->implode('-');

        $orderId = uniqid().'-'.$orderIdParts;

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $totalAmount,
            ],
            'item_details' => $itemDetails,
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        return view('payments.confirmation', compact('snapToken', 'orderId', 'itemDetails'));
    }

    public function createPaymentSession(Request $request)
    {
        $user = auth()->user();

        // Decode JSON menjadi array
        $itemDetails = json_decode($request->itemDetails, true);

        // Simpan snap token dan detail transaksi
        PaymentSession::create([
            'user_id' => $user->id,
            'order_id' => $request->orderId,
            'snap_token' => $request->snapToken,
            'status' => 'pending',
            'item_details' => $itemDetails,
        ]);

        return redirect()->route('payments.index');
    }

    public function handleCallback(Request $request)
    {
        // Mendapatkan notifikasi dari Midtrans
        $notification = new Notification();

        $transactionStatus = $notification->transaction_status;
        $orderId = $notification->order_id;

        $paymentSession = PaymentSession::where('order_id', $orderId)->first();
        if ($paymentSession) {
            if ($transactionStatus == 'settlement') {
                $paymentSession->status = 'settlement';
                $paymentSession->save();
            } elseif ($transactionStatus == 'pending') {
                $paymentSession->status = 'pending';
                $paymentSession->save();
            } elseif ($transactionStatus == 'expire') {
                $paymentSession->status = 'expire';
                $paymentSession->save();
            }
        }

        // Memproses order_id untuk mendapatkan bagian item details
        // order_id format: uniqid-sid-iid
        $orderIdParts = explode('-', $orderId);
        
        // Bagian kedua dari $orderIdParts adalah daftar item (sid, iid)
        $itemIds = array_slice($orderIdParts, 1);

        // Mendapatkan saldo awal
        $currentBalance = $this->getLatestBalance();
        
        foreach ($itemIds as $itemId) {
            if (strpos($itemId, 's') !== false) {
                $savingId = str_replace('s', '', $itemId);
                $saving = Saving::find($savingId);
                if ($saving && $transactionStatus == 'settlement') {
                    $saving->status = 'dibayar';
                    $saving->save();

                    // Menghitung saldo baru setelah transaksi simpanan
                    $currentBalance += $saving->jumlah + $saving->denda;

                    // Menyimpan data transaksi simpanan
                    Transaction::create([
                        'date' => now(),
                        'description' => "Diterima simpanan {$saving->jenis_simpanan} anggota a/n {$saving->user->name}",
                        'debit' => $saving->jumlah + $saving->denda,
                        'balance' => $currentBalance,
                    ]);
                } elseif ($saving && $transactionStatus == 'pending') {
                    $saving->status = 'pending';
                    $saving->save();
                } elseif ($saving && $transactionStatus == 'expire') {
                    $saving->status = 'belum bayar';
                    $saving->save();
                }
            }

            if (strpos($itemId, 'i') !== false) {
                $installmentId = str_replace('i', '', $itemId);
                $installment = Installment::find($installmentId);
                if ($installment && $transactionStatus == 'settlement') {
                    $installment->status = 'dibayar';
                    $installment->save();

                    // Menghitung saldo baru setelah transaksi angsuran
                    $currentBalance += $installment->jumlah + $installment->denda;

                    // Menyimpan data transaksi angsuran
                    Transaction::create([
                        'date' => now(),
                        'description' => "Diterima angsuran pinjaman anggota a/n {$installment->loan->user->name}",
                        'debit' => $installment->jumlah + $installment->denda,
                        'balance' => $currentBalance,
                    ]);

                    // Cek apakah semua angsuran terkait pinjaman ini sudah dibayar
                    $loan = $installment->loan; // Ambil pinjaman terkait dari angsuran
                    $remainingInstallments = $loan->installments()->where('status', 'belum bayar')->count();

                    if ($remainingInstallments === 0) {
                        // Jika tidak ada angsuran yang tersisa, ubah status pinjaman menjadi lunas
                        $loan->status = 'lunas';
                        $loan->keterangan = 'pinjaman sudah dilunasi';
                        $loan->save();
                    }
                } elseif ($installment && $transactionStatus == 'pending') {
                    $installment->status = 'pending';
                    $installment->save();
                } elseif ($installment && $transactionStatus == 'expire') {
                    $installment->status = 'belum bayar';
                    $installment->save();
                }
            }
        }

        return response()->json(['message' => 'Callback processed successfully.']);
    }

    // Fungsi untuk mendapatkan saldo terakhir
    private function getLatestBalance()
    {
        $latestTransaction = Transaction::orderBy('id', 'desc')->first();
        return $latestTransaction ? $latestTransaction->balance : 0;
    }

    public function calculateLateFee($dueDate, $paymentDate)
    {
        $lateFee = null;
        $daysLate = $paymentDate->diffInDays($dueDate);

        if ($daysLate > 0) {
            $lateFee = $daysLate * 1000;
        }

        return $lateFee;
    }
}

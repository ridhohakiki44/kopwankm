<?php

namespace App\Http\Controllers;

use App\Models\Installment;
use App\Models\Saving;
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

        return view('payments.index', compact('savings', 'installments'));
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

        // Hitung total pembayaran
        $totalAmount = $savings->sum('jumlah') + $installments->sum('jumlah');

        // Menyiapkan item details
        $itemDetails = collect($savings)->map(function($saving) {
            return [
                'id' => 'saving-'.$saving->id,
                'price' => $saving->jumlah,
                'quantity' => 1,
                'name' => 'Simpanan '.$saving->jenis_simpanan,
            ];
        })->merge($installments->map(function($installment) {
            return [
                'id' => 'installment-'.$installment->id,
                'price' => $installment->jumlah,
                'quantity' => 1,
                'name' => 'Angsuran Pinjaman ID '.$installment->loan_id,
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

        return view('payments.confirmation', compact('snapToken'));
    }

    public function handleCallback(Request $request)
    {
        // Mendapatkan notifikasi dari Midtrans
        $notification = new Notification();

        $transactionStatus = $notification->transaction_status;
        $orderId = $notification->order_id;

        // Memproses order_id untuk mendapatkan bagian item details
        // order_id format: uniqid-sid-iid
        $orderIdParts = explode('-', $orderId);
        
        // Bagian kedua dari $orderIdParts adalah daftar item (sid, iid)
        $itemIds = array_slice($orderIdParts, 1);
        
        foreach ($itemIds as $itemId) {
            if (strpos($itemId, 's') !== false) {
                $savingId = str_replace('s', '', $itemId);
                $saving = Saving::find($savingId);
                if ($saving && $transactionStatus == 'settlement') {
                    $saving->status = 'dibayar';
                    $saving->save();
                }
            }

            if (strpos($itemId, 'i') !== false) {
                $installmentId = str_replace('i', '', $itemId);
                $installment = Installment::find($installmentId);
                if ($installment && $transactionStatus == 'settlement') {
                    $installment->status = 'dibayar';
                    $installment->save();
                }
            }
        }

        return response()->json(['message' => 'Callback processed successfully.']);
    }
}

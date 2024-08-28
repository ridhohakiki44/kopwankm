<?php

namespace App\Http\Controllers;

use App\Models\loan;
use App\Models\Saving;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class SavingController extends Controller
{
    public function index()
    {
        $savings = auth()->user()->role == 'anggota'
        ? auth()->user()->savings
        : Saving::with('user')->get();

        return view('savings.index', compact('savings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_simpanan' => 'required|string',
            'jumlah' => 'required|numeric|min:0',
        ]);

        $saving = new Saving();
        $saving->user_id = auth()->id();
        $saving->jenis_simpanan = $request->jenis_simpanan;
        $saving->jumlah = $request->jumlah;
        $saving->save();

        return redirect()->route('savings.index')->with('status', 'Saving created successfully.');
    }

    public function createBySekretaris()
    {
        // Ambil semua data user dengan role 'anggota'
        $users = User::where('role', 'anggota')->get();

        return view('savings.create-by-sekretaris', compact('users'));
    }

    public function storeBySekretaris(Request $request)
    {
        // Validasi input
        $request->validate([
            'user_id' => 'required|array|min:1', // Pastikan user_id adalah array dan memiliki setidaknya satu elemen
            'user_id.*' => 'exists:users,id',    // Setiap elemen dalam array user_id harus ada di tabel users
            'jenis_simpanan' => 'required|string',
            'jumlah' => 'nullable|numeric', // Jumlah hanya perlu ada untuk jenis simpanan sukarela
            'status' => 'required|string'
        ]);
        
        $userIds = $request->user_id;
        $jenisSimpanan = $request->jenis_simpanan;
        $status = $request->status;

        foreach ($userIds as $userId) {
            $jumlah = 0;
    
            if ($jenisSimpanan === 'wajib') {
                $loan = Loan::where('user_id', $userId)
                            ->where('status', 'belum lunas')
                            ->first();
    
                $jumlah = 20000; // Default untuk tidak punya pinjaman atau sudah lunas
    
                if ($loan) {
                    if ($loan->jumlah >= 50000000) {
                        $jumlah = 100000;
                    } elseif ($loan->jumlah >= 10000000) {
                        $jumlah = 50000;
                    }
                }
            } else {
                $jumlah = $request->jumlah;
            }
    
            Saving::create([
                'user_id' => $userId,
                'jenis_simpanan' => $jenisSimpanan,
                'jumlah' => $jumlah,
                'status' => $status,
            ]);
            
            if ($status === 'dibayar') {
                // Ambil nama pengguna berdasarkan user_id
                $user = User::find($userId);
                $userName = $user->name;
        
                // Ambil saldo dari transaksi terakhir
                $currentBalance = Transaction::latest('id')->first()->balance ?? 0;
                
                // Menghitung saldo berdasarkan debit
                $currentBalance += $jumlah;
        
                // Menyimpan data transaksi simpanan
                Transaction::create([
                    'date' => now(),
                    'description' => "Diterima simpanan {$jenisSimpanan} anggota a/n {$userName}",
                    'debit' => $jumlah,
                    'balance' => $currentBalance,
                ]);
            }
        }

        return redirect()->back()->with('status', 'Simpanan berhasil ditambahkan.');
    }

    public function getWajibSavingsAmount($userId = null)
    {
        $user = $userId ? User::find($userId) : auth()->user();
        $loan = loan::where('user_id', $user->id)
                    ->where('status', 'belum lunas')
                    ->first();

        $jumlah = 20000; // Default untuk tidak punya pinjaman atau sudah lunas

        if ($loan) {
            if ($loan->jumlah >= 50000000) {
                $jumlah = 100000;
            } elseif ($loan->jumlah >= 10000000) {
                $jumlah = 50000;
            }
        }

        return response()->json(['jumlah' => $jumlah]);
    }
}

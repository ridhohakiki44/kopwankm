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
            'user_id' => 'required|exists:users,id',
            'jenis_simpanan' => 'required|string',
            'jumlah' => 'required|numeric|min:1000',
        ]);

        // Buat simpanan baru
        $saving = new Saving();
        $saving->user_id = $request->user_id;
        $saving->jenis_simpanan = $request->jenis_simpanan;
        $saving->jumlah = $request->jumlah;
        $saving->status = 'dibayar';
        $saving->save();

        // Ambil nama pengguna berdasarkan user_id
        $user = User::find($request->user_id);
        $userName = $user->name;

        // Ambil saldo dari transaksi terakhir
        $currentBalance = Transaction::latest('id')->first()->balance ?? 0;
        
        // Menghitung saldo berdasarkan debit
        $balance = $currentBalance + $request->jumlah;

        // Menyimpan data transaksi simpanan
        Transaction::create([
            'date' => now(),
            'description' => "Diterima simpanan {$request->jenis_simpanan} anggota a/n {$userName}",
            'debit' => $request->jumlah,
            'balance' => $balance,
        ]);

        // Redirect ke halaman sebelumnya dengan pesan sukses
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

<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        // Mendapatkan semua transaksi
        $transactions = Transaction::orderBy('id', 'desc')->get();
        return view('transactions.index', compact('transactions'));
    }

    public function setBalance(Request $request, Transaction $transaction)
    {
        $request->validate([
            'description' => 'required|string',
            'balance' => 'required|numeric',
        ]);

        $transaction->date = now();
        $transaction->description = $request->description;
        $transaction->balance = $request->balance;
        $transaction->save();

        return redirect()->back()->with('status', 'Status dan keterangan berhasil diperbarui');
    }

    public function create()
    {
        return view('transactions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string',
            'type' => 'required|string',
            'amount' => 'nullable|numeric',
        ]);
        
        if ($request->type == 'debit') {
            $debit = $request->amount;
            $credit = null;
        } else {
            $credit = $request->amount;
            $debit = null;
        }
        
        $currentBalance = Transaction::latest('id')->first()->balance ?? 0;
        
        // Menghitung saldo berdasarkan debit dan kredit
        $balance = $currentBalance + $debit - $credit;

        // Menyimpan transaksi baru
        Transaction::create([
            'date' => now(),
            'description' => $request->description,
            'debit' => $debit,
            'credit' => $credit,
            'balance' => $balance,
        ]);

        return redirect()->route('transactions.index')->with('status', 'Transaksi berhasil ditambahkan.');
    }

    public function edit(Transaction $transaction)
    {
        return view('transactions.edit', compact('transaction'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'date' => 'required|date',
            'description' => 'required|string|max:255',
            'debit' => 'nullable|numeric',
            'kredit' => 'nullable|numeric',
        ]);

        // Cari transaksi sebelumnya berdasarkan date
        $previousTransaction = Transaction::where('date', '<', $transaction->date)
                                            ->orderBy('date', 'desc')
                                            ->first();

        // Jika ada transaksi sebelumnya, ambil saldo terakhirnya, jika tidak, saldo terakhir adalah 0
        $saldo_terakhir = $previousTransaction->saldo ?? 0;

        // Menghitung saldo baru untuk transaksi yang sedang diedit
        $saldo = $saldo_terakhir + ($request->debit ?? 0) - ($request->kredit ?? 0);

        // Update transaksi yang sedang diedit
        $transaction->update([
            'date' => $request->date,
            'description' => $request->description,
            'debit' => $request->debit,
            'kredit' => $request->kredit,
            'saldo' => $saldo,
        ]);

        // Perbarui saldo untuk semua transaksi berikutnya
        $nextTransactions = Transaction::where('date', '>', $transaction->date)
                                    ->orderBy('date', 'asc')
                                    ->get();

        foreach ($nextTransactions as $nextTransaction) {
            $saldo += $nextTransaction->debit - $nextTransaction->kredit;
            $nextTransaction->saldo = $saldo;
            $nextTransaction->save();
        }

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diperbarui.');
    }
}

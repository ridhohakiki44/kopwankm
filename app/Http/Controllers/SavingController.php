<?php

namespace App\Http\Controllers;

use App\Models\loan;
use App\Models\Saving;
use Illuminate\Http\Request;

class SavingController extends Controller
{
    public function index()
    {
        $savings = auth()->user()->savings;
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

    public function getWajibSavingsAmount()
    {
        $user = auth()->user();
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

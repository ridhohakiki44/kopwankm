<?php

namespace App\Http\Controllers;

use App\Models\Saving;
use Illuminate\Http\Request;

class SavingController extends Controller
{
    public function index()
    {
        $savings = auth()->user()->savings;
        return view('savings.index', compact('savings'));
    }

    public function create()
    {
        return view('savings.create');
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
        return view('savings.create');
    }
}

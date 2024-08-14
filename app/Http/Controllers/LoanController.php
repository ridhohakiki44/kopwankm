<?php

namespace App\Http\Controllers;

use App\Models\Installment;
use App\Models\loan;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index()
    {
        $loans = auth()->user()->loans;
        return view('loans.index', compact('loans'));
    }

    public function create()
    {
        return view('loans.ajukan');
    }

    public function ajukan(Request $request)
    {
        $request->validate([
            'jumlah' => 'required|numeric|min:100000',
            'jangka_waktu' => 'required|integer|min:1',
            'bank' => 'required|string',
            'no_rek' => 'required|string',
            'jaminan' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('jaminan')) {
            $jaminanPath = $request->file('jaminan')->store('jaminan', 'public');
            $validatedData['jaminan'] = $jaminanPath;
        }

        loan::create([
            'user_id' => auth()->id(),
            'jumlah' => $request->jumlah,
            'jangka_waktu' => $request->jangka_waktu,
            'bank' => $request->bank,
            'no_rek' => $request->no_rek,
            'jaminan' => $jaminanPath,
        ]);

        return redirect()->route('loans.index')->with('status', 'Pengajuan pinjaman berhasil, menunggu persetujuan.');
    }

    public function showVerificationPage()
    {
        $pengajuanLoans = Loan::where('status', 'mengajukan')->get();
        return view('loans.verifikasi', compact('pengajuanLoans'));
    }
    
    public function verifySetujui($id, Request $request)
    {
        $loan = Loan::findOrFail($id);
        
        $loan->status = 'disetujui';
        $loan->keterangan = $request->keterangan;
        $loan->save();

        // Buat angsuran berdasarkan jangka waktu
        $jumlahAngsuran = $loan->jumlah / $loan->jangka_waktu + $loan->jumlah * 1 / 100;
        $jumlahAngsuran = round($jumlahAngsuran);

        for ($i = 1; $i <= $loan->jangka_waktu; $i++) {
            Installment::create([
                'loan_id' => $loan->id,
                'jumlah' => $jumlahAngsuran,
                'jatuh_tempo' => now()->addMonths($i),
                'status' => 'belum bayar',
            ]);
        }

        return redirect()->route('loans.verification.page')->with('status', 'Pinjaman telah disetujui dan angsuran telah dibuat.');
    }

    public function verifyTolak($id, Request $request)
    {
        $loan = Loan::findOrFail($id);

        $loan->status = 'ditolak';
        $loan->keterangan = $request->keterangan;
        $loan->save();

        return redirect()->route('loans.verification.page')->with('status', 'Pinjaman telah ditolak.');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class PermohonanKeanggotaanController extends Controller
{
    /**
     * Menampilkan halaman permohonan keanggotaan.
     */
    public function index(): View
    {
        return view('permohonan-keanggotaan');
    }

    /**
     * Pengajuan menjadi anggota.
     */
    public function ajukan(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'role' => 'nullable|string|max:20',
            'nik' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255',
            'nomor_telepon' => 'nullable|string|max:15',
            'tanggal_lahir' => 'nullable|date',
            'pekerjaan' => 'nullable|string|max:255',
            'penghasilan' => 'nullable|string|max:255',
            'ktp' => 'nullable|string|max:255',
            'kartu_keluarga' => 'nullable|string|max:255',
        ]);

        $user = $request->user();
        $user->fill($validatedData);
        $user->save();

        return Redirect::route('welcome')->with('status', 'Permohonan keanggotaan berhasil diajukan.');
    }
}

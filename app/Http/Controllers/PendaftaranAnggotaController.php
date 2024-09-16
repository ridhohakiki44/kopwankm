<?php

namespace App\Http\Controllers;

use App\Models\Saving;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PendaftaranAnggotaController extends Controller
{
    // Menampilkan halaman pendaftaran anggota.
    public function showForm(): View
    {
        return view('pendaftaran-anggota.form-pendaftaran-anggota');
    }

    // Pengajuan menjadi anggota.
    public function ajukan(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'nik' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255',
            'nomor_telepon' => 'nullable|string|max:15',
            'tanggal_lahir' => 'nullable|date',
            'penghasilan' => 'nullable|string|max:255',
            'ktp' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'kartu_keluarga' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = $request->user();
        
         // Handle file upload for KTP
        if ($request->hasFile('ktp')) {
            if ($user->ktp) {
                Storage::disk('public')->delete($user->ktp);
            }
            $ktpPath = $request->file('ktp')->store('ktp', 'public');
            $validatedData['ktp'] = $ktpPath;
        }

        // Handle file upload for Kartu Keluarga
        if ($request->hasFile('kartu_keluarga')) {
            if ($user->kartu_keluarga) {
                Storage::disk('public')->delete($user->kartu_keluarga);
            }
            $kartuKeluargaPath = $request->file('kartu_keluarga')->store('kartu_keluarga', 'public');
            $validatedData['kartu_keluarga'] = $kartuKeluargaPath;
        }

        $pekerjaan = '';
        if($request->pekerjaan_lainnya != 'none') {
            $pekerjaan = $request->pekerjaan_lainnya;
        } else {
            $pekerjaan = $request->pekerjaan;
        }

        $user->fill($validatedData);
        $user->status_pk = 'mengajukan';
        $user->pekerjaan = $pekerjaan;
        $user->save();

        return Redirect::route('welcome')->with('status', 'Pendaftaran anggota berhasil diajukan.');
    }

    public function showVerifikasi(): View
    {
        $pengajuans = User::where('status_pk', 'mengajukan')->get();

        return view('pendaftaran-anggota.verifikasi-pendaftaran-anggota', compact('pengajuans'));
    }

    public function verifikasi($id)
    {
        $user = User::findOrFail($id);
        $user->role = 'anggota';
        $user->status_pk = 'diverifikasi';
        $user->save();

        // Tambahkan simpanan pokok
        $simpananPokok = new Saving();
        $simpananPokok->user_id = $user->id;
        $simpananPokok->jenis_simpanan = 'pokok';
        $simpananPokok->jumlah = 100000;
        $simpananPokok->save();

        // Tambahkan simpanan wajib
        $simpananWajib = new Saving();
        $simpananWajib->user_id = $user->id;
        $simpananWajib->jenis_simpanan = 'wajib';
        $simpananWajib->jumlah = 20000;
        $simpananWajib->save();
        
        return redirect()->route('verifikasi-pendaftaran')->with('status', 'Pendaftaran anggota berhasil diverifikasi dan simpanan awal telah ditambahkan.');
    }

    public function tolak($id)
    {
        $user = User::findOrFail($id);
        $user->status_pk = 'ditolak';
        $user->save();

        return redirect()->route('verifikasi-pendaftaran')->with('status', 'Pendaftaran anggota berhasil ditolak.');
    }
}

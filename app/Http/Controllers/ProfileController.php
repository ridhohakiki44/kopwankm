<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Ambil pengguna saat ini
        $user = $request->user();

        // Dapatkan data yang sudah divalidasi
        $validatedData = $request->validated();

        // Hapus avatar lama jika ada dan unggahan baru
        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $validatedData['avatar'] = $path;
        }

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

        if($request->pekerjaan_lainnya == '') {
            $validatedData['pekerjaan'] = $request->pekerjaan;
        } else {
            $validatedData['pekerjaan'] = $request->pekerjaan_lainnya;
        }
        
        $user->fill($validatedData);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}

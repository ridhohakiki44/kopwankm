<?php

namespace App\Http\Controllers;

use App\Models\loan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    // dashboard user dengan role
    public function dashboard(): View
    {
        $permohonanKeanggotaanCount = User::where('status_pk', 'mengajukan')->count();
        $anggotaCount = User::where('role', 'anggota')->count();
        $pengajuanPinjamanCount = loan::where('status', 'mengajukan')->count();
        $menungguPencairanDanaCount = loan::where('status', 'disetujui')->count();
        return view('dashboard', compact('permohonanKeanggotaanCount', 'pengajuanPinjamanCount', 'menungguPencairanDanaCount', 'anggotaCount'));
    }

    // dashboard user tanpa role
    public function welcome(): View
    {
        return view('welcome');
    }
}

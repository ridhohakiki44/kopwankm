<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    // dashboard user dengan role
    public function dashboard(): View
    {
        $permohonanKeanggotaanCount = User::where('status_pk', 'mengajukan')->count();
        return view('dashboard', compact('permohonanKeanggotaanCount'));
    }

    // dashboard user tanpa role
    public function welcome(): View
    {
        return view('welcome');
    }
}

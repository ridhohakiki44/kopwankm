<?php

namespace App\Http\Controllers;

use App\Models\Installment;
use Illuminate\Http\Request;

class InstallmentController extends Controller
{
    public function index()
    {
        $installments = auth()->user()->role == 'anggota'
        ? Installment::whereRelation('loan', 'user_id', auth()->id())->with('loan')->get()
        : Installment::with('loan')->get();
        
        return view('installments.index', compact('installments'));
    }
}

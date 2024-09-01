<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_id',
        'jumlah',
        'denda',
        'jatuh_tempo',
        'status',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}

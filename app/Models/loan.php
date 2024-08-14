<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'jumlah',
        'jangka_waktu',
        'bank',
        'no_rek',
        'jaminan',
        'status',
        'keterangan',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function installments()
    {
        return $this->hasMany(Installment::class);
    }
}

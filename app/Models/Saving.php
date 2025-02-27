<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saving extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'jenis_simpanan',
        'jumlah',
        'denda',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

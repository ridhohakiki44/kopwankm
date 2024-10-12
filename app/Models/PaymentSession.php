<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentSession extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'order_id', 'snap_token', 'status', 'item_details'];

    protected $casts = [
        'item_details' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

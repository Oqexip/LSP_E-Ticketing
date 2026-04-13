<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';

    protected $fillable = [
        'booking_id',
        'payment_method',
        'amount',
        'payment_proof',
        'status',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}

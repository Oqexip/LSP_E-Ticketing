<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'schedules';

    protected $fillable = [
        'plane_name',
        'origin',
        'destination',
        'departure',
        'price',
        'stock',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}

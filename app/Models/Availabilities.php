<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Availabilities extends Model
{
    // app/Models/Availability.php
    protected $fillable = [
        'doctor_id',
        'specialty_id',
        'customer_id',
        'day',
        'start_time',
        'end_time',
        'status_id',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function specialty()
    {
        return $this->belongsTo(Specialty::class, 'specialty_id');
    }

}

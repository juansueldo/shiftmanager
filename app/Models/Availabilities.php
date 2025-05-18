<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Availabilities extends Model
{
    // app/Models/Availability.php
    protected $fillable = [
        'doctor_id',
        'specialty_id',
        'day',
        'start_time',
        'end_time',
        'status_id',];

}

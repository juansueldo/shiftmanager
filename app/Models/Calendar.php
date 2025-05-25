<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    protected $fillable = [
        'title',
        'description',
        'date',
        'google_event_id',
        'patientid',
        'status'

    ];

    public function status(){
        return $this->belongsTo(Status::class, 'status');
    }

    public function getDateFormat(){
        return Carbon::parse($this->date)->format('Y-m-d');
    }

    public function getTimeFormat(){
        return Carbon::parse($this->date)->format('H:i');
    }
}

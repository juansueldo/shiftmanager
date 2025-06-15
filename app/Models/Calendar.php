<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    protected $fillable = [
        'title',
        'customer_id',
        'description',
        'date',
        'google_event_id',
        'patientid',
        'status'

    ];

    public function status(){
        return $this->belongsTo(Status::class, 'status');
    }

    public function patient(){
        return $this->belongsTo(Patient::class, 'patientid');
    }

    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function getDateFormat(){
        return Carbon::parse($this->date)->format('Y-m-d');
    }

    public function getTimeFormat(){
        return Carbon::parse($this->date)->format('H:i');
    }
}

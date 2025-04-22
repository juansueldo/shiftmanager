<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class DoctorSpecialty extends Pivot
{
    protected $table = 'doctor_specialty';

    // Si querés, podés agregar un accesor para alias:
    public function getAliasIdAttribute()
    {
        return $this->attributes['id'];
    }
}

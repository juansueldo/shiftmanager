<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Status extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function users()
    {
        return $this->hasMany(User::class, 'status');
    }

    public function doctors(){
        return $this->hasMany(Doctor::class, 'status');
    }

    public function calendars(){
        return $this->hasMany(Calendar::class, 'status');
    }
}

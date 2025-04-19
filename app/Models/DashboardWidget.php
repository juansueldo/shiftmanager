<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DashboardWidget extends Model
{
    protected $fillable = ['user_id', 'name', 'x', 'y', 'width', 'height'];
}

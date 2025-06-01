<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{

    protected $table = 'role_user';

    protected $fillable = [
        'user_id',
        'role_id',
        'status_id',
    ];

    // Relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function role()
    {
        return $this->belongsTo(Rol::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}

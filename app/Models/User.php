<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasAttributes;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use HasAttributes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'avatar',
        'email',
        'google_id',
        'google_token',
        'google_refresh_token',
        'token_expires_at',
        'password',
        'language',
        'status', 
    ];

    protected $dates = ['token_expires_at'];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
             'token_expires_at' => 'datetime',
        ];
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status');
    }

    public function scopeFilter($query, $params){
        $query->select('users.*', 'statuses.name as status_name')
            ->leftJoin('statuses', 'users.status', '=', 'statuses.id');
    
        if (!empty($params['search'])) {
            $search = $params['search'];
            $query->where(function ($q) use ($search) {
                $q->where('users.firstname', 'like', "%{$search}%")
                    ->orWhere('users.lastname', 'like', "%{$search}%")
                    ->orWhere('users.email', 'like', "%{$search}%")
                    ->orWhere('statuses.name', 'like', "%{$search}%");
            });
        }
    
        $orderColumn = $params['ordercolumn'] ?? 'id';
        $orderColumn = is_string($orderColumn) ? strtolower($orderColumn) : 'id';
    
        $orderMethod = strtolower($params['ordermethod'] ?? 'asc');
    
        if (!in_array($orderMethod, ['asc', 'desc'])) {
            $orderMethod = 'asc';
        }
    
        $query->orderBy($orderColumn, $orderMethod);
    
        return $query;
    }
    
}

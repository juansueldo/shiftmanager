<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasAttributes;
use Illuminate\Support\Facades\Auth;

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
        'customer_id',
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

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'role_user')
                ->withPivot('status_id')
                ->withTimestamps();
    }

    public function doctor(){
        return $this->hasOne(Doctor::class);
    }
    
    public function scopeFilter($query, $params)
    {
        $query->select('users.*', 'statuses.name as status_name', 'rols.name as role_name')
            ->leftJoin('role_user', 'users.id', '=', 'role_user.user_id')
            ->leftJoin('rols', 'role_user.role_id', '=', 'rols.id')
            ->leftJoin('statuses', 'users.status', '=', 'statuses.id'); 

        $customerId = $params['customer_id'] ?? (Auth::check() ? Auth::user()->customer_id : null);
        if ($customerId) {
            $query->where('users.customer_id', $customerId);
        }
        if (!empty($params['search'])) {
            $search = $params['search'];
            $query->where(function ($q) use ($search) {
                $q->where('users.firstname', 'like', "%{$search}%")
                    ->orWhere('users.lastname', 'like', "%{$search}%")
                    ->orWhere('users.email', 'like', "%{$search}%")
                    ->orWhere('rols.name', 'like', "%{$search}%")
                    ->orWhere('statuses.name', 'like', "%{$search}%");
            });
        }

        // Solo permitir columnas válidas para ordenar
        $allowedOrderColumns = [
            'id' => 'users.id',
            'firstname' => 'users.firstname',
            'lastname' => 'users.lastname',
            'email' => 'users.email',
            'status_name' => 'statuses.name',
            'role_name' => 'rols.name',
        ];

        $orderColumn = $params['ordercolumn'] ?? 'id';
        $orderColumn = is_string($orderColumn) ? strtolower($orderColumn) : 'id';
        $orderBy = $allowedOrderColumns[$orderColumn] ?? 'users.id';

        $orderMethod = strtolower($params['ordermethod'] ?? 'asc');
        if (!in_array($orderMethod, ['asc', 'desc'])) {
            $orderMethod = 'asc';
        }

        $query->orderBy($orderBy, $orderMethod);

        return $query;
    }
    
}

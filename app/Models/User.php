<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasAttributes;
use Illuminate\Support\Facades\Auth;
use App\Models\Traits\DatatableFilter;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, DatatableFilter;
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
    
    /**
     * Get datatable configuration for User model
     *
     * @return array
     */
    protected function getDatatableConfig(): array
    {
        return [
            'select' => ['users.*', 'statuses.name as status_name', 'rols.name as role_name'],
            'joins' => [
                [
                    'table' => 'role_user',
                    'first' => 'users.id',
                    'operator' => '=',
                    'second' => 'role_user.user_id',
                ],
                [
                    'table' => 'rols',
                    'first' => 'role_user.role_id',
                    'operator' => '=',
                    'second' => 'rols.id',
                ],
                [
                    'table' => 'statuses',
                    'first' => 'users.status',
                    'operator' => '=',
                    'second' => 'statuses.id',
                ],
            ],
            'searchable' => [
                'users.firstname',
                'users.lastname',
                'users.email',
                'rols.name',
                'statuses.name',
            ],
            'filter_by_customer' => true,
            'customer_column' => 'users.customer_id',
            'default_order_column' => 'id',
            'allowed_order_columns' => [
                'id' => 'users.id',
                'firstname' => 'users.firstname',
                'lastname' => 'users.lastname',
                'email' => 'users.email',
                'status_name' => 'statuses.name',
                'role_name' => 'rols.name',
            ],
        ];
    }

}

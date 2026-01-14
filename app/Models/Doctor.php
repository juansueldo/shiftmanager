<?php

namespace App\Models;

use App\Models\Traits\DatatableFilter;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use DatatableFilter;

    protected $fillable = [
        'user_id',
        'phone',
        'address',
        'city',
        'state',
        'zip',
        'country',
        'date_of_birth',
        'identifier',
        'status',
    ];

    public function status()
    {
        return $this->belongsTo(Status::class, 'status');
    }

    public function specialties()
    {
        return $this->belongsToMany(Specialty::class, 'doctor_specialty')
            ->withPivot('status_id')
            ->withPivot('id')
            ->wherePivot('status_id', 1)
            ->withTimestamps();
    }

    public function activeSpecialties()
    {
        return $this->belongsToMany(Specialty::class, 'doctor_specialty')
            ->withPivot('status_id', 'id')
            ->wherePivot('status_id', 1)
            ->withTimestamps();
    }

    public function allSpecialties()
    {
        return $this->belongsToMany(Specialty::class, 'doctor_specialty')
            ->withPivot('status_id', 'id')
            ->withTimestamps();
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get datatable configuration for Doctor model
     */
    protected function getDatatableConfig(): array
    {
        return [
            'select' => [
                'doctors.*',
                'users.firstname as firstname',
                'users.lastname as lastname',
                'users.email as email',
                'statuses.name as status_name',
            ],
            'joins' => [
                [
                    'table' => 'users',
                    'first' => 'doctors.user_id',
                    'operator' => '=',
                    'second' => 'users.id',
                ],
                [
                    'table' => 'statuses',
                    'first' => 'doctors.status',
                    'operator' => '=',
                    'second' => 'statuses.id',
                ],
            ],
            'searchable' => [
                'users.firstname',
                'users.lastname',
                'users.email',
                'statuses.name',
            ],
            'filter_by_customer' => true,
            'customer_column' => 'users.customer_id',
            'default_order_column' => 'doctors.id',
            'allowed_order_columns' => [
                'doctors.id' => 'doctors.id',
                'users.firstname' => 'users.firstname',
                'users.lastname' => 'users.lastname',
                'users.email' => 'users.email',
                'statuses.name' => 'statuses.name',
            ],
        ];
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Traits\DatatableFilter;

class Specialty extends Model
{
    use DatatableFilter;
    
    protected $fillable =[
        'name',
        'status'
    ];

    /**
     * Get datatable configuration for Specialty model
     *
     * @return array
     */
    protected function getDatatableConfig(): array
    {
        return [
            'select' => ['specialties.*', 'statuses.name as status_name'],
            'joins' => [
                [
                    'table' => 'statuses',
                    'first' => 'specialties.status',
                    'operator' => '=',
                    'second' => 'statuses.id',
                ],
            ],
            'searchable' => [
                'specialties.name',
                'statuses.name',
            ],
            'filter_by_customer' => false,
            'default_order_column' => 'id',
            'allowed_order_columns' => [
                'specialties.id' => 'specialties.id',
                'specialties.name' => 'specialties.name',
                'statuses.name' => 'statuses.name',
            ],
        ];
    }

    public function doctors()
    {
        return $this->belongsToMany(Doctor::class, 'doctor_specialty')
            ->withPivot('status_id')
            ->withTimestamps();
    }
}

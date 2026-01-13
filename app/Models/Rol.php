<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\DatatableFilter;

class Rol extends Model
{
    use DatatableFilter;
    
    protected $fillable = [
        'name',
        'status'
    ];
    public function status()
    {
        return $this->belongsTo(Status::class, 'status');
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user')
                ->withPivot('status_id')
                ->withTimestamps();
    }

    /**
     * Get datatable configuration for Rol model
     *
     * @return array
     */
    protected function getDatatableConfig(): array
    {
        return [
            'select' => ['rols.*', 'statuses.name as status_name'],
            'joins' => [
                [
                    'table' => 'statuses',
                    'first' => 'rols.status',
                    'operator' => '=',
                    'second' => 'statuses.id',
                ],
            ],
            'searchable' => [
                'rols.name',
                'statuses.name',
            ],
            'filter_by_customer' => false,
            'default_order_column' => 'id',
            'allowed_order_columns' => [
                'rols.id' => 'rols.id',
                'rols.name' => 'rols.name',
                'statuses.name' => 'statuses.name',
            ],
        ];
    }
}

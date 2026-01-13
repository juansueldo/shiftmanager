<?php

namespace App\Models;

use App\Models\Traits\DatatableFilter;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use DatatableFilter;

    protected $fillable = [
        'firstname',
        'lastname',
        'customer_id',
        'email',
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

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Get datatable configuration for Patient model
     */
    protected function getDatatableConfig(): array
    {
        return [
            'select' => ['patients.*', 'statuses.name as status_name'],
            'joins' => [
                [
                    'table' => 'statuses',
                    'first' => 'patients.status',
                    'operator' => '=',
                    'second' => 'statuses.id',
                ],
            ],
            'searchable' => [
                'patients.firstname',
                'patients.lastname',
                'patients.email',
                'patients.identifier',
                'statuses.name',
            ],
            'filter_by_customer' => true,
            'customer_column' => 'patients.customer_id',
            'default_order_column' => 'id',
            'allowed_order_columns' => [
                'patients.id' => 'patients.id',
                'patients.firstname' => 'patients.firstname',
                'patients.lastname' => 'patients.lastname',
                'patients.email' => 'patients.email',
                'patients.identifier' => 'patients.identifier',
                'statuses.name' => 'statuses.name',
            ],
        ];
    }
}

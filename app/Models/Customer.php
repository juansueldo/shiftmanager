<?php

namespace App\Models;

use App\Models\Traits\DatatableFilter;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use DatatableFilter;

    protected $fillable = [
        'firstname',
        'lastname',
        'company_name',
        'company_email',
        'company_phone',
        'company_address',
        'company_city',
        'company_state',
        'company_zip',
        'company_country',
        'company_vat',
        'status',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    /**
     * Get datatable configuration for Customer model
     */
    protected function getDatatableConfig(): array
    {
        return [
            'select' => ['customers.*', 'statuses.name as status_name'],
            'joins' => [
                [
                    'table' => 'statuses',
                    'first' => 'customers.status',
                    'operator' => '=',
                    'second' => 'statuses.id',
                ],
            ],
            'searchable' => [
                'customers.firstname',
                'statuses.name',
            ],
            'filter_by_customer' => false,
            'default_order_column' => 'id',
            'allowed_order_columns' => [
                'customers.id' => 'customers.id',
                'customers.firstname' => 'customers.firstname',
                'statuses.name' => 'statuses.name',
            ],
        ];
    }
}

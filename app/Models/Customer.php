<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
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
        'status'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
    public function scopeFilter($query, $params)
    {
        $query->select('customers.*', 'statuses.name as status_name')
            ->leftJoin('statuses', 'customers.status', '=', 'statuses.id');

        if (!empty($params['search'])) {
            $search = $params['search'];
            $query->where(function ($q) use ($search) {
                $q->where('customers.firstname', 'like', "%{$search}%")
                    ->orWhere('statuses.name', 'like', "%{$search}%");
            });
        }

        $orderColumn = $params['ordercolumn'] ?? 'customers.id';
        $orderColumn = is_string($orderColumn) ? strtolower($orderColumn) : 'id';

        $orderMethod = strtolower($params['ordermethod'] ?? 'asc');

        if (!in_array($orderMethod, ['asc', 'desc'])) {
            $orderMethod = 'asc';
        }

        $query->orderBy($orderColumn, $orderMethod);

        return $query;
    }
}

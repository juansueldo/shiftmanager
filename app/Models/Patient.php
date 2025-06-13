<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Patient extends Model
{
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
        'status'
    ];

    public function status()
    {
        return $this->belongsTo(Status::class, 'status');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function scopeFilter($query, $params){
        $query->select('patients.*', 'statuses.name as status_name')
            ->leftJoin('statuses', 'patients.status', '=', 'statuses.id');
         $customerId = $params['customer_id'] ?? (Auth::check() ? Auth::user()->customer_id : null);
        if ($customerId) {
            $query->where('patients.customer_id', $customerId);
        }
        if (!empty($params['search'])) {
            $search = $params['search'];
            $query->where(function ($q) use ($search) {
                $q->where('patients.firstname', 'like', "%{$search}%")
                    ->orWhere('patients.lastname', 'like', "%{$search}%")
                    ->orWhere('patients.email', 'like', "%{$search}%")
                    ->orWhere('patients.identifier', 'like', "%{$search}%")
                    ->orWhere('statuses.name', 'like', "%{$search}%");
            });
        }
    
        $orderColumn = $params['ordercolumn'] ?? 'patients.id';
        $orderColumn = is_string($orderColumn) ? strtolower($orderColumn) : 'id';
    
        $orderMethod = strtolower($params['ordermethod'] ?? 'asc');
    
        if (!in_array($orderMethod, ['asc', 'desc'])) {
            $orderMethod = 'asc';
        }
    
        $query->orderBy($orderColumn, $orderMethod);
    
        return $query;
    }
    
}

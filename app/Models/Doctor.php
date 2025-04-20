<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'firstname',
        'lastname',
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
    public function specialties()
    {
        return $this->belongsToMany(Specialty::class, 'doctor_specialty')
            ->withPivot('status_id')
            ->withTimestamps();
    }
    public function scopeFilter($query, $params){
        $query->select('doctors.*', 'statuses.name as status_name')
            ->leftJoin('statuses', 'doctors.status', '=', 'statuses.id');
    
        if (!empty($params['search'])) {
            $search = $params['search'];
            $query->where(function ($q) use ($search) {
                $q->where('doctors.firstname', 'like', "%{$search}%")
                    ->orWhere('doctors.lastname', 'like', "%{$search}%")
                    ->orWhere('doctors.email', 'like', "%{$search}%")
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

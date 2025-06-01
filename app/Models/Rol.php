<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
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

    public function scopeFilter($query, $params)
    {
        $query->select('rols.*', 'statuses.name as status_name')
            ->leftJoin('statuses', 'rols.status', '=', 'statuses.id');

        if (!empty($params['search'])) {
            $search = $params['search'];
            $query->where(function ($q) use ($search) {
                $q->where('rols.name', 'like', "%{$search}%")
                    ->orWhere('statuses.name', 'like', "%{$search}%");
            });
        }

        $orderColumn = $params['ordercolumn'] ?? 'rols.id';
        $orderColumn = is_string($orderColumn) ? strtolower($orderColumn) : 'id';

        $orderMethod = strtolower($params['ordermethod'] ?? 'asc');

        if (!in_array($orderMethod, ['asc', 'desc'])) {
            $orderMethod = 'asc';
        }

        $query->orderBy($orderColumn, $orderMethod);

        return $query;
    }
}

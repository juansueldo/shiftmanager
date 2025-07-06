<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Status extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function users()
    {
        return $this->hasMany(User::class, 'status');
    }

    public function doctors(){
        return $this->hasMany(Doctor::class, 'status');
    }

    public function calendars(){
        return $this->hasMany(Calendar::class, 'status');
    }
    public function scopeFilter($query, $params)
    {
        $query->select('statuses.*');

        if (!empty($params['search'])) {
            $search = $params['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
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

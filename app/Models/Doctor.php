<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Doctor extends Model
{
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
    public function user(){
        return $this->belongsTo(User::class);
    }
   public function scopeFilter($query, $params)
{
    $query->select(
            'doctors.*',
            'users.firstname as firstname',
            'users.lastname as lastname',
            'users.email as email',
            'statuses.name as status_name'
        )
        ->leftJoin('users', 'doctors.user_id', '=', 'users.id')
        ->leftJoin('statuses', 'doctors.status', '=', 'statuses.id');

    // Filtrado por customer_id
    $customerId = $params['customer_id'] ?? (Auth::check() ? Auth::user()->customer_id : null);
    if ($customerId) {
        $query->where('users.customer_id', $customerId);
    }

    // Búsqueda por nombre, apellido, email, estado
    if (!empty($params['search'])) {
        $search = $params['search'];
        $query->where(function ($q) use ($search) {
            $q->where('users.firstname', 'like', "%{$search}%")
                ->orWhere('users.lastname', 'like', "%{$search}%")
                ->orWhere('users.email', 'like', "%{$search}%")
                ->orWhere('statuses.name', 'like', "%{$search}%");
        });
    }

    // Ordenamiento seguro
    $allowedOrderColumns = [
        'doctors.id',
        'users.firstname',
        'users.lastname',
        'users.email',
        'statuses.name'
    ];

    $orderColumn = $params['ordercolumn'] ?? 'doctors.id';
    $orderMethod = strtolower($params['ordermethod'] ?? 'asc');

    if (!in_array($orderMethod, ['asc', 'desc'])) {
        $orderMethod = 'asc';
    }

    // Validar columna de orden
    if (!in_array($orderColumn, $allowedOrderColumns)) {
        $orderColumn = 'doctors.id';
    }

    $query->orderBy($orderColumn, $orderMethod);

    return $query;
}

}

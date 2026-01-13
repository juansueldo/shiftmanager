<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Traits\DatatableFilter;

class Status extends Model
{
    use HasFactory, DatatableFilter;

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

    /**
     * Get datatable configuration for Status model
     *
     * @return array
     */
    protected function getDatatableConfig(): array
    {
        return [
            'select' => ['statuses.*'],
            'joins' => [],
            'searchable' => [
                'name',
            ],
            'filter_by_customer' => false,
            'default_order_column' => 'id',
            'allowed_order_columns' => [
                'id' => 'id',
                'name' => 'name',
            ],
        ];
    }
}

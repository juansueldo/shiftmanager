<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Auth;

trait DatatableFilter
{
    /**
     * Generic scope filter for datatable operations
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $params
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, $params)
    {
        $config = $this->getDatatableConfig();

        // Apply select statement
        $query->select($config['select']);

        // Apply joins
        foreach ($config['joins'] as $join) {
            $query->leftJoin($join['table'], $join['first'], $join['operator'], $join['second']);
        }

        // Apply customer filter if configured
        if ($config['filter_by_customer'] ?? false) {
            $customerId = $params['customer_id'] ?? (Auth::check() ? Auth::user()->customer_id : null);
            if ($customerId) {
                $query->where($config['customer_column'], $customerId);
            }
        }

        // Apply search filters
        if (!empty($params['search']) && !empty($config['searchable'])) {
            $search = $params['search'];
            $query->where(function ($q) use ($search, $config) {
                foreach ($config['searchable'] as $index => $column) {
                    if ($index === 0) {
                        $q->where($column, 'like', "%{$search}%");
                    } else {
                        $q->orWhere($column, 'like', "%{$search}%");
                    }
                }
            });
        }

        // Apply ordering
        $orderColumn = $params['ordercolumn'] ?? $config['default_order_column'];
        $orderColumn = is_string($orderColumn) ? strtolower($orderColumn) : $config['default_order_column'];

        // Map column alias to actual column if using allowed columns
        if (!empty($config['allowed_order_columns'])) {
            $orderBy = $config['allowed_order_columns'][$orderColumn] ?? $config['allowed_order_columns'][$config['default_order_column']];
        } else {
            $orderBy = $orderColumn;
        }

        $orderMethod = strtolower($params['ordermethod'] ?? 'asc');
        if (!in_array($orderMethod, ['asc', 'desc'])) {
            $orderMethod = 'asc';
        }

        $query->orderBy($orderBy, $orderMethod);

        return $query;
    }

    /**
     * Get datatable configuration for this model
     * Override this method in your model to customize behavior
     *
     * @return array
     */
    protected function getDatatableConfig(): array
    {
        return [
            // Columns to select
            'select' => [$this->getTable() . '.*'],
            
            // Joins configuration
            'joins' => [],
            
            // Searchable columns
            'searchable' => [],
            
            // Filter by customer
            'filter_by_customer' => false,
            'customer_column' => $this->getTable() . '.customer_id',
            
            // Order configuration
            'default_order_column' => 'id',
            'allowed_order_columns' => [],
        ];
    }
}

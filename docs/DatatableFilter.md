# DatatableFilter Trait - Documentation

## Overview

The `DatatableFilter` trait provides a generic, reusable implementation of the `scopeFilter` method for Laravel models that need datatable filtering functionality. It eliminates code duplication by centralizing common filtering logic.

## Features

- **Configurable joins**: Define left joins with any related tables
- **Full-text search**: Search across multiple columns with a single query parameter
- **Safe column ordering**: Whitelist allowed order columns to prevent SQL injection
- **Customer filtering**: Optional filtering by customer_id for multi-tenant applications
- **Flexible configuration**: Each model defines its own configuration via `getDatatableConfig()`

## Usage

### 1. Add the Trait to Your Model

```php
use App\Models\Traits\DatatableFilter;

class YourModel extends Model
{
    use DatatableFilter;
    
    // ... rest of your model
}
```

### 2. Override `getDatatableConfig()` Method

Define your model's specific configuration:

```php
protected function getDatatableConfig(): array
{
    return [
        // Columns to select (required)
        'select' => ['your_table.*', 'related_table.column as alias'],
        
        // Joins configuration (optional)
        'joins' => [
            [
                'table' => 'related_table',
                'first' => 'your_table.foreign_key',
                'operator' => '=',
                'second' => 'related_table.id',
            ],
        ],
        
        // Searchable columns (optional)
        'searchable' => [
            'your_table.column1',
            'your_table.column2',
            'related_table.column',
        ],
        
        // Filter by customer (optional, default: false)
        'filter_by_customer' => true,
        'customer_column' => 'your_table.customer_id',
        
        // Order configuration
        'default_order_column' => 'id',
        'allowed_order_columns' => [
            'id' => 'your_table.id',
            'name' => 'your_table.name',
            'status' => 'related_table.status',
        ],
    ];
}
```

### 3. Use the Filter in Controllers

```php
public function index(Request $request)
{
    $params = [
        'search' => $request->input('search'),
        'ordercolumn' => $request->input('ordercolumn', 'id'),
        'ordermethod' => $request->input('ordermethod', 'asc'),
        'customer_id' => auth()->user()->customer_id, // Optional
    ];
    
    $results = YourModel::filter($params)->paginate(10);
    
    return view('your.view', compact('results'));
}
```

## Configuration Options

### Required Options

- **`select`** (array): Columns to select in the query. Always include the base table columns.

### Optional Options

- **`joins`** (array): Array of join configurations. Each join requires:
  - `table`: Table name to join
  - `first`: First column in the join condition
  - `operator`: Join operator (usually `=`)
  - `second`: Second column in the join condition

- **`searchable`** (array): Columns that will be searched when the `search` parameter is provided. Search uses `LIKE %term%` matching.

- **`filter_by_customer`** (boolean): Enable/disable customer filtering. Default: `false`

- **`customer_column`** (string): The column name for customer filtering. Default: `{table}.customer_id`

- **`default_order_column`** (string): Default column for ordering. Default: `id`

- **`allowed_order_columns`** (array): Whitelist of allowed order columns. Maps aliases to actual column names. If empty, no validation is performed.

## Request Parameters

The `filter()` scope accepts an array with the following parameters:

- **`search`** (string): Search term to filter results
- **`ordercolumn`** (string): Column to order by (must be in `allowed_order_columns`)
- **`ordermethod`** (string): Order direction (`asc` or `desc`)
- **`customer_id`** (integer): Customer ID to filter by (if `filter_by_customer` is enabled)

## Examples

### Basic Configuration (No Joins)

```php
protected function getDatatableConfig(): array
{
    return [
        'select' => ['statuses.*'],
        'joins' => [],
        'searchable' => ['name'],
        'filter_by_customer' => false,
        'default_order_column' => 'id',
        'allowed_order_columns' => [
            'id' => 'id',
            'name' => 'name',
        ],
    ];
}
```

### Advanced Configuration (Multiple Joins)

```php
protected function getDatatableConfig(): array
{
    return [
        'select' => [
            'users.*',
            'statuses.name as status_name',
            'rols.name as role_name'
        ],
        'joins' => [
            [
                'table' => 'role_user',
                'first' => 'users.id',
                'operator' => '=',
                'second' => 'role_user.user_id',
            ],
            [
                'table' => 'rols',
                'first' => 'role_user.role_id',
                'operator' => '=',
                'second' => 'rols.id',
            ],
            [
                'table' => 'statuses',
                'first' => 'users.status',
                'operator' => '=',
                'second' => 'statuses.id',
            ],
        ],
        'searchable' => [
            'users.firstname',
            'users.lastname',
            'users.email',
            'rols.name',
            'statuses.name',
        ],
        'filter_by_customer' => true,
        'customer_column' => 'users.customer_id',
        'default_order_column' => 'id',
        'allowed_order_columns' => [
            'id' => 'users.id',
            'firstname' => 'users.firstname',
            'lastname' => 'users.lastname',
            'email' => 'users.email',
            'status_name' => 'statuses.name',
            'role_name' => 'rols.name',
        ],
    ];
}
```

## Security Considerations

- The trait uses **whitelisted columns** for ordering to prevent SQL injection
- Order methods are validated to only allow `asc` or `desc`
- Search uses Laravel's query builder with parameter binding
- Customer filtering respects authentication context

## Testing

The trait includes comprehensive unit tests covering:
- Method existence validation
- Configuration validation
- Search functionality
- Custom ordering
- Invalid parameter handling
- Model-specific configurations

Run tests with:
```bash
php artisan test --filter=DatatableFilterTest
```

## Models Using This Trait

The following models currently implement the DatatableFilter trait:

- `User`
- `Doctor`
- `Patient`
- `Customer`
- `Specialty`
- `Rol`
- `Status`

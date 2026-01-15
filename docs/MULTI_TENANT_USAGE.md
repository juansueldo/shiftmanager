# Multi-Tenant Usage Guide

## Overview
ShiftManager now supports multi-tenancy with slug-based routing. Each customer has their own subdirectory in the application, providing data isolation and a branded experience.

## URL Structure

### Before (Single Tenant)
```
http://app.com/dashboard
http://app.com/patients
http://app.com/doctors
```

### After (Multi-Tenant)
```
http://app.com/{slug}/dashboard
http://app.com/{slug}/patients
http://app.com/{slug}/doctors
```

Where `{slug}` is the unique identifier for each customer (e.g., `acme-clinic`, `metro-hospital`)

## Registration Flow

### New Customer Registration

When a user registers:
1. Customer record is created with auto-generated slug
2. Slug is generated from `company_name` or `firstname + lastname`
3. Slug is unique and URL-safe (lowercase, alphanumeric, hyphens)
4. User is automatically associated with the new customer
5. User is redirected to `/{slug}/dashboard`

**Example**:
- Company: "Acme Clinic"
- Generated slug: `acme-clinic`
- Dashboard URL: `http://app.com/acme-clinic/dashboard`

### Slug Generation Logic
```php
// If company name is "Acme Clinic"
$slug = "acme-clinic"

// If slug exists, append number
$slug = "acme-clinic-2"
```

## Login Flow

### Existing User Login
1. User enters email and password
2. System authenticates user
3. User is redirected to their customer's dashboard: `/{slug}/dashboard`

### No Slug Edge Case
- If user has no customer or slug, fallback to `/dashboard` (should not happen in normal flow)

## Tenant Detection

### How It Works
1. Middleware `SetTenantFromSlug` runs on every tenant-scoped request
2. Extracts `{slug}` from URL
3. Looks up customer by slug
4. Validates customer is active (`status = 1`)
5. Sets tenant in request, config, and views
6. If slug invalid or customer inactive: **404 Not Found**

### Accessing Current Tenant

**In Controllers**:
```php
$tenant = tenant(); // Returns Customer model or null
$slug = tenant_slug(); // Returns slug string or null
$customerId = tenant()->id;
```

**In Views (Blade)**:
```blade
{{ $tenant->company_name }}
{{ $tenant->slug }}
```

**In Routes**:
```php
return redirect()->route('dashboard.index', ['slug' => tenant_slug()]);

// Or use helper
return redirect(tenant_route('dashboard.index'));
```

## Data Isolation

### Tables with Customer Isolation

All the following tables now have `customer_id` foreign key:

1. **users** - Users belong to a customer
2. **patients** - Patients belong to a customer
3. **calendars** - Appointments belong to a customer
4. **specialties** - Each customer defines their specialties
5. **doctors** - Doctors belong to a customer (via user)
6. **rols** - Roles can be customer-specific or system-wide
7. **statuses** - Statuses can be customer-specific or system-wide
8. **dashboard_widgets** - Widgets belong to user and customer
9. **doctor_specialty** - Pivot table is customer-scoped
10. **availabilities** - Doctor availability is customer-scoped

### How Filtering Works

**Automatic Filtering**:
Models using `DatatableFilter` trait with `filter_by_customer = true` automatically filter by current tenant.

**Example**:
```php
// In SpecialtyController
$query = Specialty::filter($request->all());
// Automatically adds: WHERE specialties.customer_id = {current_tenant_id}
```

**Manual Filtering**:
```php
$specialties = Specialty::where('customer_id', tenant()->id)->get();
```

## Creating Records

### Auto-Setting customer_id

Controllers should auto-set `customer_id` when creating records:

```php
Specialty::create([
    'name' => $request->input('name'),
    'customer_id' => tenant()->id,
    'status' => 1,
]);
```

### Validation with Tenant Scope

Ensure uniqueness within tenant:

```php
$request->validate([
    'name' => 'required|string|max:255|unique:specialties,name,' . $request->id . ',id,customer_id,' . tenant()->id,
]);
```

## System vs Tenant Data

### System-Wide Data (Nullable customer_id)

Some data can be shared across all tenants:
- **System Roles**: Admin, Doctor, Patient (customer_id = NULL)
- **System Statuses**: Active, Inactive (customer_id = NULL)

### Tenant-Specific Data

Custom roles and statuses created by each tenant:
- **Custom Role**: "Specialist Nurse" (customer_id = 123)
- **Custom Status**: "Waiting for Approval" (customer_id = 123)

### Querying Combined Data

```php
// Get system + tenant-specific roles
$roles = Rol::whereNull('customer_id')
    ->orWhere('customer_id', tenant()->id)
    ->get();
```

## Middleware Setup

### Current Configuration

In `routes/web.php`:
```php
Route::prefix('{slug}')
    ->middleware(['auth', SetTenantFromSlug::class])
    ->group(function () {
        // All tenant routes here
    });
```

### Routes Outside Tenant Context

These routes do NOT require slug:
- `/login` - Login page
- `/register` - Registration page
- `/landing` - Landing page
- `/auth/google` - OAuth callbacks

## Migrations

### Running Migrations

```bash
php artisan migrate
```

This will:
1. Add `slug` column to `customers` table
2. Add `customer_id` to 6 additional tables
3. Create foreign key constraints

### Rollback

```bash
php artisan migrate:rollback --step=7
```

### Seeding

After migration, you may need to:
1. Generate slugs for existing customers
2. Assign customer_id to existing data

**Example Seeder**:
```php
// Generate slugs for existing customers
foreach (Customer::whereNull('slug')->get() as $customer) {
    $customer->slug = Customer::generateSlug($customer->company_name ?? $customer->firstname);
    $customer->save();
}
```

## Testing Multi-Tenancy

### Manual Testing

1. **Register Two Customers**:
   - Register as "Acme Clinic" → Gets slug `acme-clinic`
   - Register as "Metro Hospital" → Gets slug `metro-hospital`

2. **Create Data in Each Tenant**:
   - Login as Acme Clinic user
   - Create specialty "Cardiology"
   - Create patient "John Doe"

3. **Verify Isolation**:
   - Login as Metro Hospital user
   - Should NOT see Acme's "Cardiology" specialty
   - Should NOT see Acme's patient "John Doe"

4. **Test Slug Routing**:
   - Navigate to `/acme-clinic/dashboard` - Should work
   - Navigate to `/metro-hospital/dashboard` - Should work
   - Navigate to `/invalid-slug/dashboard` - Should 404

### Automated Testing

Create feature tests:

```php
public function test_tenant_can_only_see_their_data()
{
    $tenant1 = Customer::factory()->create(['slug' => 'tenant1']);
    $tenant2 = Customer::factory()->create(['slug' => 'tenant2']);
    
    $user1 = User::factory()->create(['customer_id' => $tenant1->id]);
    $specialty1 = Specialty::factory()->create(['customer_id' => $tenant1->id]);
    
    $this->actingAs($user1);
    $response = $this->get('/tenant1/specialty');
    
    $response->assertSee($specialty1->name);
}
```

## Troubleshooting

### Issue: 404 on Dashboard
**Cause**: Missing slug in URL
**Solution**: Ensure you're accessing `/{slug}/dashboard` not just `/dashboard`

### Issue: Customer not found
**Cause**: Invalid or inactive customer slug
**Solution**: 
- Verify customer exists: `Customer::where('slug', 'your-slug')->first()`
- Verify customer is active: `status = 1`

### Issue: Cross-tenant data visible
**Cause**: Missing customer_id filter
**Solution**: Ensure DatatableFilter is configured with `filter_by_customer = true`

### Issue: Slug conflict during registration
**Cause**: Slug already exists
**Solution**: Slug generation automatically appends number (e.g., `clinic-2`)

## Best Practices

### 1. Always Use Helper Functions
```php
// Good
$customer = tenant();
$slug = tenant_slug();
return redirect(tenant_route('dashboard.index'));

// Avoid
$customer = config('app.current_tenant');
$slug = request()->route('slug');
```

### 2. Validate Tenant Access in Policies
```php
public function view(User $user, Patient $patient)
{
    return $user->customer_id === $patient->customer_id;
}
```

### 3. Include Slug in All Redirects
```php
// Good
return redirect()->route('patients.index', ['slug' => tenant_slug()]);

// Bad (will fail in multi-tenant setup)
return redirect()->route('patients.index');
```

### 4. Scope All Queries by Tenant
```php
// Good
$patients = Patient::where('customer_id', tenant()->id)->get();

// Better (if using DatatableFilter)
$patients = Patient::filter($request->all());
```

### 5. Never Hardcode Slugs
```php
// Bad
return redirect('/acme-clinic/dashboard');

// Good
return redirect(tenant_route('dashboard.index'));
```

## Migration Checklist

- [x] Database schema updated (slug, customer_id columns)
- [x] Models updated (relationships, fillable)
- [x] Middleware created and applied
- [x] Routes updated with slug prefix
- [x] Helper functions created
- [x] Authentication flow updated
- [ ] All controllers updated (in progress)
- [ ] All views updated with tenant_route()
- [ ] Seeders updated for system/tenant data
- [ ] Tests created
- [ ] Documentation completed
- [ ] Production migration plan

## Next Steps

1. Update remaining controllers to auto-set customer_id
2. Update all view files to use `tenant_route()` helper
3. Create seeders for system roles/statuses
4. Add comprehensive tests
5. Update deployment documentation
6. Plan data migration for existing deployments

## FAQ

**Q: Can a user belong to multiple tenants?**
A: Currently no. Each user belongs to one customer. Future enhancement could support this.

**Q: Can I change my tenant's slug?**
A: Yes, but you'd need to update all bookmarks/links. Consider redirect implementation.

**Q: What happens if I access wrong tenant's URL?**
A: Middleware validates user's customer matches URL slug. Mismatch should redirect or error.

**Q: How do I create system-wide data?**
A: Set `customer_id = NULL` for system roles/statuses that all tenants can see.

**Q: Can tenants have custom domains?**
A: Not currently. This would require subdomain routing instead of path-based.

## Support

For issues or questions:
1. Check this documentation
2. Review `docs/MULTI_TENANT_IMPLICATIONS.md` for technical details
3. Check migration files in `database/migrations/`
4. Review helper functions in `app/helpers.php`

# Multi-Tenant Adaptation Implications

## Overview
This document outlines all the implications of adapting ShiftManager for multi-tenant support with customer slug-based routing.

## Architecture Changes

### 1. Database Schema Changes

#### 1.1 Customer Table (`customers`)
- **ADD**: `slug` column (VARCHAR, UNIQUE, NOT NULL)
  - Used for tenant identification in URLs
  - Example: `http://app.com/{slug}/dashboard`
  - Must be URL-safe (lowercase, alphanumeric, hyphens)
  
#### 1.2 Tables Missing `customer_id` Foreign Key
The following tables need `customer_id` to ensure proper data isolation:

- **specialties** - Currently shared across all customers, should be per-tenant
  - Impact: Each customer can define their own specialties
  - Migration: Add `customer_id` column with foreign key

- **doctor_specialty** - Pivot table for doctor-specialty relationships
  - Impact: Ensure relationships are tenant-scoped
  - Migration: Add `customer_id` column with foreign key

- **availabilities** - Doctor availability schedules
  - Impact: Already isolated via doctor->user->customer, but explicit customer_id adds clarity
  - Migration: Add `customer_id` column with foreign key

- **rols** (roles) - Currently shared, should be per-tenant
  - Impact: Each customer can define custom roles
  - Migration: Add `customer_id` column, seed default roles per customer

- **statuses** - Currently shared, should be per-tenant
  - Impact: Each customer can customize statuses
  - Migration: Add `customer_id` column, seed default statuses per customer

- **dashboard_widgets** - User dashboard widgets
  - Impact: Already user-specific, customer_id adds explicit isolation
  - Migration: Add `customer_id` column with foreign key

### 2. Routing Changes

#### 2.1 Slug-Based Routes
Current structure:
```
/dashboard
/calendar
/patients
/doctors
```

New structure:
```
/{slug}/dashboard
/{slug}/calendar
/{slug}/patients
/{slug}/doctors
```

#### 2.2 Route Files
- **web.php**: Add route group with `{slug}` prefix
- All authenticated routes must be within slug group
- Login/register can remain outside slug OR accept optional slug

#### 2.3 URL Generation
- All `route()` calls need slug parameter
- Helper function to get current tenant slug
- Update form actions and redirects

### 3. Middleware Changes

#### 3.1 New Middleware: `SetTenantFromSlug`
- **Purpose**: Detect and validate tenant from URL slug
- **Responsibilities**:
  - Extract slug from route parameter
  - Find customer by slug
  - Validate customer exists and is active
  - Set tenant in session/request
  - Abort with 404 if slug invalid

#### 3.2 Middleware Registration
- Add to `app/Http/Kernel.php` or `bootstrap/app.php` (Laravel 12)
- Apply to all tenant routes

### 4. Model Changes

#### 4.1 Customer Model
- Add `slug` to fillable
- Add slug validation rules
- Add slug generation method (from company name)
- Add slug uniqueness validation

#### 4.2 Specialty Model
- Add `customer_id` to fillable
- Update datatable config: `filter_by_customer` = true
- Add customer relationship

#### 4.3 Rol Model  
- Add `customer_id` to fillable (nullable for system roles)
- Update queries to filter by customer
- Distinguish between system roles and custom roles

#### 4.4 Status Model
- Add `customer_id` to fillable (nullable for system statuses)
- Update queries to filter by customer
- Distinguish between system statuses and custom statuses

#### 4.5 DashboardWidget Model
- Add `customer_id` to fillable
- Add relationship to customer

#### 4.6 Availabilities Model
- Add `customer_id` to fillable
- Add relationship to customer

#### 4.7 DoctorSpecialty Model (if exists as model)
- Add `customer_id` to fillable

### 5. Controller Changes

#### 5.1 All Controllers
- Access tenant via middleware-injected data
- Ensure all create operations set `customer_id`
- Update redirect routes to include slug

#### 5.2 Specific Controller Updates

**SpecialtyController**:
- Filter specialties by customer
- Auto-set customer_id on create

**RolesController**:
- Filter roles by customer (or show system + customer roles)
- Auto-set customer_id on create
- Prevent deletion of system roles

**StatusesController**:
- Filter statuses by customer (or show system + customer statuses)
- Auto-set customer_id on create (for custom statuses)
- Prevent modification of system statuses

**DashboardController**:
- No major changes (already uses auth user's customer)

**CalendarController**:
- Already sets customer_id correctly

**PatientController**:
- Already sets customer_id correctly

**DoctorController**:
- Ensure specialty filtering is customer-scoped

**UserController**:
- Already sets customer_id correctly

#### 5.3 Authentication Controllers

**LoginController**:
- After login, redirect to customer's slug-based dashboard
- Handle users with no customer (admin users?)

**RegisterController**:
- Create customer with generated slug
- Handle slug conflicts during registration

### 6. View Changes

#### 6.1 URL Generation
- Update all `route()` calls to include slug
- Example: `route('dashboard.index', ['slug' => $customer->slug])`

#### 6.2 Forms
- Update form actions to use slug-aware routes
- Ensure redirects preserve slug

#### 6.3 Navigation
- Sidebar/navbar links must include slug

### 7. Data Access Patterns

#### 7.1 Current Scoping (Already Implemented)
- Users, Patients, Calendars: Filtered by `customer_id`
- Doctors: Filtered via user's `customer_id`

#### 7.2 New Scoping Required
- Specialties: Must filter by current customer
- Roles: Show system + customer-specific roles
- Statuses: Show system + customer-specific statuses
- Dashboard Widgets: Already user-scoped, add customer for consistency

### 8. Seeder Changes

#### 8.1 StatusSeeder
- Create system statuses with `customer_id = NULL`
- OR create default statuses for each customer

#### 8.2 RolesTableSeeder
- Create system roles with `customer_id = NULL`
- OR create default roles for each customer

#### 8.3 New: CustomerSeeder (for testing)
- Create demo customers with slugs

### 9. Authorization / Policies

#### 9.1 Policy Updates
- Ensure policies check tenant ownership
- User can only access data within their customer
- Prevent cross-tenant data access

#### 9.2 Gate Definitions
- Check user's customer_id matches resource's customer_id

### 10. Session / State Management

#### 10.1 Tenant Context
- Store current tenant (customer) in session
- Middleware sets tenant on each request
- Global helper to access current tenant

#### 10.2 Multi-Tenant Switching
- Support for users belonging to multiple customers?
- If yes: Need tenant switching mechanism
- If no: User belongs to single customer only

### 11. Testing Implications

#### 11.1 Unit Tests
- Test slug generation
- Test slug uniqueness
- Test customer lookup by slug

#### 11.2 Feature Tests
- Test slug-based routing
- Test tenant isolation
- Test cross-tenant access prevention

#### 11.3 Database Factories
- Update factories to include customer_id
- Create customer factory with slug

### 12. API Implications (Future)
If API is added:
- API authentication must include tenant identification
- API routes: `/api/{slug}/...` OR header-based tenant detection
- API tokens scoped to customer

### 13. File Storage Implications
- If files are stored (avatars, documents):
  - Organize by tenant: `storage/app/{slug}/avatars/`
  - Ensure tenant can't access other tenant's files

### 14. Caching Implications
- Cache keys must include tenant identifier
- Example: `cache:customers:{slug}:patients`
- Prevent cross-tenant cache poisoning

### 15. Queue / Jobs Implications
- Jobs that process tenant data must know tenant context
- Pass customer_id or slug to jobs
- Ensure jobs don't cross tenant boundaries

### 16. Search Implications
- All search queries must be scoped to current tenant
- Prevent cross-tenant search results

### 17. Reporting / Analytics Implications
- Reports must be tenant-scoped
- Admin/super-admin might see cross-tenant reports

### 18. Backup / Export Implications
- Data exports must be tenant-specific
- Ensure GDPR compliance per tenant

### 19. Subdomain vs Path-Based Routing

Current Approach: **Path-Based** (`app.com/{slug}/...`)

Alternative: **Subdomain** (`{slug}.app.com/...`)
- Requires wildcard DNS
- Better isolation
- More complex deployment

### 20. Migration Strategy

#### Phase 1: Add Slug to Customers
1. Add slug column to customers table
2. Generate slugs for existing customers
3. Make slug unique and required

#### Phase 2: Add customer_id to Missing Tables
1. Add customer_id to specialties, rols, statuses, etc.
2. Migrate existing data (assign to default customer or create per customer)

#### Phase 3: Update Code
1. Create tenant middleware
2. Update routes
3. Update controllers
4. Update views

#### Phase 4: Testing
1. Test tenant isolation
2. Test slug routing
3. Test data scoping

### 21. Potential Issues / Edge Cases

#### 21.1 Slug Conflicts
- What if desired slug is taken?
- Suggest alternatives during registration

#### 21.2 Slug Changes
- Allow customers to change their slug?
- If yes: Update all URLs, handle redirects

#### 21.3 Reserved Slugs
- Prevent use of: `api`, `admin`, `login`, `register`, etc.

#### 21.4 System vs Tenant Data
- Some data (statuses, roles) might be system-wide
- Need to distinguish between system and tenant data

#### 21.5 Existing Data Migration
- How to assign customer_id to existing shared data?
- Option 1: Assign to first/default customer
- Option 2: Duplicate for each customer

## Summary

Multi-tenant adaptation with slug-based routing requires:

1. **Database**: Add slug to customers, customer_id to 6+ tables
2. **Routing**: Wrap all routes in `/{slug}` group
3. **Middleware**: Create tenant detection middleware
4. **Models**: Add customer relationships and scoping
5. **Controllers**: Auto-set customer_id, filter by customer
6. **Views**: Update all URL generation
7. **Seeders**: Handle system vs tenant data
8. **Testing**: Ensure tenant isolation

**Complexity Level**: Medium-High
**Estimated Tables Modified**: 10+
**Estimated Code Files Modified**: 50+
**Testing Required**: Extensive

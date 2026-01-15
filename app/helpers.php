<?php

if (! function_exists('tenant')) {
    /**
     * Get the current tenant (customer) from request or config
     */
    function tenant(): ?\App\Models\Customer
    {
        // Try to get from config first (set by middleware)
        $tenant = config('app.current_tenant');
        
        if ($tenant) {
            return $tenant;
        }

        // Fallback to authenticated user's customer
        if (auth()->check() && auth()->user()->customer) {
            return auth()->user()->customer;
        }

        return null;
    }
}

if (! function_exists('tenant_slug')) {
    /**
     * Get the current tenant slug
     */
    function tenant_slug(): ?string
    {
        $tenant = tenant();
        return $tenant ? $tenant->slug : null;
    }
}

if (! function_exists('tenant_route')) {
    /**
     * Generate a route URL with tenant slug
     */
    function tenant_route(string $name, array $parameters = [], bool $absolute = true): string
    {
        $slug = tenant_slug() ?? request()->route('slug');
        
        if ($slug) {
            $parameters = array_merge(['slug' => $slug], $parameters);
        }
        
        return route($name, $parameters, $absolute);
    }
}

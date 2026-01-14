<?php

namespace App\Http\Middleware;

use App\Models\Customer;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetTenantFromSlug
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $slug = $request->route('slug');

        if (!$slug) {
            // If no slug in route, check if user is authenticated and redirect to their customer slug
            if (auth()->check() && auth()->user()->customer) {
                return redirect()->route('dashboard.index', ['slug' => auth()->user()->customer->slug]);
            }
            abort(404, 'Tenant not found');
        }

        // Find customer by slug
        $customer = Customer::where('slug', $slug)
            ->where('status', 1) // Only active customers
            ->first();

        if (!$customer) {
            abort(404, 'Tenant not found');
        }

        // Store customer in request for easy access throughout the application
        $request->merge(['tenant' => $customer]);
        
        // Also store in config for global access
        config(['app.current_tenant' => $customer]);

        // Share with views
        view()->share('tenant', $customer);

        return $next($request);
    }
}

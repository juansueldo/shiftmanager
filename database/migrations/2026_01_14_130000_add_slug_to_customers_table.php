<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            // Add slug as nullable first to allow data migration
            $table->string('slug')->nullable()->after('id');
        });

        // Generate slugs for existing customers (if any)
        $this->generateSlugsForExistingCustomers();

        // Make slug unique and required after population
        Schema::table('customers', function (Blueprint $table) {
            $table->string('slug')->unique()->nullable(false)->change();
        });
    }

    /**
     * Generate slugs for existing customers
     */
    private function generateSlugsForExistingCustomers(): void
    {
        $customers = \App\Models\Customer::whereNull('slug')->get();
        
        foreach ($customers as $customer) {
            $baseName = $customer->company_name ?? ($customer->firstname . ' ' . $customer->lastname);
            $customer->slug = \App\Models\Customer::generateSlug($baseName);
            $customer->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};

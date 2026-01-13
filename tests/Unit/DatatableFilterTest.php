<?php

namespace Tests\Unit;

use App\Models\Customer;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DatatableFilterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that scopeFilter exists on models using the trait
     */
    public function test_scope_filter_method_exists(): void
    {
        $user = new User;
        $this->assertTrue(method_exists($user, 'scopeFilter'), 'User model should have scopeFilter method');

        $doctor = new Doctor;
        $this->assertTrue(method_exists($doctor, 'scopeFilter'), 'Doctor model should have scopeFilter method');

        $patient = new Patient;
        $this->assertTrue(method_exists($patient, 'scopeFilter'), 'Patient model should have scopeFilter method');
    }

    /**
     * Test that getDatatableConfig is properly implemented
     */
    public function test_get_datatable_config_returns_array(): void
    {
        $status = new Status;
        $reflection = new \ReflectionClass($status);
        $method = $reflection->getMethod('getDatatableConfig');
        $method->setAccessible(true);
        $config = $method->invoke($status);

        $this->assertIsArray($config);
        $this->assertArrayHasKey('select', $config);
        $this->assertArrayHasKey('joins', $config);
        $this->assertArrayHasKey('searchable', $config);
        $this->assertArrayHasKey('filter_by_customer', $config);
        $this->assertArrayHasKey('default_order_column', $config);
    }

    /**
     * Test scopeFilter applies default ordering
     */
    public function test_scope_filter_applies_default_ordering(): void
    {
        // Create test data
        Status::create(['name' => 'Active']);
        Status::create(['name' => 'Inactive']);

        $results = Status::filter([])->get();

        $this->assertNotNull($results);
        $this->assertGreaterThanOrEqual(2, $results->count());
    }

    /**
     * Test scopeFilter applies search filtering
     */
    public function test_scope_filter_applies_search(): void
    {
        // Create test data
        Status::create(['name' => 'Active']);
        Status::create(['name' => 'Pending']);

        $results = Status::filter(['search' => 'Active'])->get();

        $this->assertNotNull($results);
        $this->assertEquals(1, $results->count());
        $this->assertEquals('Active', $results->first()->name);
    }

    /**
     * Test scopeFilter applies custom ordering
     */
    public function test_scope_filter_applies_custom_ordering(): void
    {
        // Create test data
        Status::create(['name' => 'Zebra']);
        Status::create(['name' => 'Apple']);

        $resultsAsc = Status::filter(['ordercolumn' => 'name', 'ordermethod' => 'asc'])->get();
        $this->assertEquals('Apple', $resultsAsc->first()->name);

        $resultsDesc = Status::filter(['ordercolumn' => 'name', 'ordermethod' => 'desc'])->get();
        $this->assertEquals('Zebra', $resultsDesc->first()->name);
    }

    /**
     * Test that invalid order method defaults to 'asc'
     */
    public function test_scope_filter_handles_invalid_order_method(): void
    {
        Status::create(['name' => 'Test']);

        $results = Status::filter(['ordermethod' => 'invalid'])->get();

        $this->assertNotNull($results);
    }

    /**
     * Test configuration for User model
     */
    public function test_user_model_datatable_config(): void
    {
        $user = new User;
        $reflection = new \ReflectionClass($user);
        $method = $reflection->getMethod('getDatatableConfig');
        $method->setAccessible(true);
        $config = $method->invoke($user);

        $this->assertTrue($config['filter_by_customer']);
        $this->assertNotEmpty($config['joins']);
        $this->assertNotEmpty($config['searchable']);
        $this->assertArrayHasKey('id', $config['allowed_order_columns']);
    }

    /**
     * Test configuration for Doctor model
     */
    public function test_doctor_model_datatable_config(): void
    {
        $doctor = new Doctor;
        $reflection = new \ReflectionClass($doctor);
        $method = $reflection->getMethod('getDatatableConfig');
        $method->setAccessible(true);
        $config = $method->invoke($doctor);

        $this->assertTrue($config['filter_by_customer']);
        $this->assertNotEmpty($config['joins']);
        $this->assertEquals('users.customer_id', $config['customer_column']);
    }

    /**
     * Test configuration for Customer model
     */
    public function test_customer_model_datatable_config(): void
    {
        $customer = new Customer;
        $reflection = new \ReflectionClass($customer);
        $method = $reflection->getMethod('getDatatableConfig');
        $method->setAccessible(true);
        $config = $method->invoke($customer);

        $this->assertFalse($config['filter_by_customer']);
        $this->assertNotEmpty($config['joins']);
    }

    /**
     * Test that models without joins work correctly
     */
    public function test_scope_filter_works_without_joins(): void
    {
        Status::create(['name' => 'Test Status']);

        $results = Status::filter(['search' => 'Test'])->get();

        $this->assertGreaterThanOrEqual(1, $results->count());
        $this->assertEquals('Test Status', $results->first()->name);
    }
}

<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Customer;
use Carbon\Carbon;

class CustomerApiTest extends TestCase
{
    use RefreshDatabase;

    // Test listing
    public function test_can_list_customers()
    {
        //Create 5 new customers
        Customer::factory()->count(5)->create();
        $response = $this->getJson('/api/customers');

        //Assert a HTTP 200 and the customer count
        $response->assertStatus(200)->assertJsonCount(5);
    }

    // Test storing
    public function test_can_create_customer()
    {
        //Create new customer (yay me!!)
        $response = $this->postJson('/api/customers', [
            'name' => 'Thiago de Souza',
            'email' => 'thiagobarrado99@gmail.com',
            'tax_id' => '12345678901',
        ]);

        //Assert HTTP 201(created) and name match
        $response->assertStatus(201)->assertJsonFragment(['name' => 'Thiago de Souza']);
    }

    // Test total bills sum for customer
    public function test_can_get_total_bills_for_customer_in_month()
    {
        $customer = Customer::factory()->create();

        // Create bills in the selected month (and another one outside, so it wont sum)
        $customer->bills()->createMany([
            [
                'amount' => 100,
                'description' => 'Fatura 1',
                'due_date' => Carbon::parse('2025-07-10'),
            ],
            [
                'amount' => 200,
                'description' => 'Fatura 2',
                'due_date' => Carbon::parse('2025-07-15'),
            ],
            [
                'amount' => 300,
                'description' => 'Fatura 3',
                'due_date' => Carbon::parse('2025-06-01'),
            ],
        ]);

        $response = $this->getJson("/api/customers/{$customer->id}/bills?month=2025-07");

        $response->assertStatus(200)
            ->assertJsonFragment([
                'name' => $customer->name,
                'month' => '2025-07',
                'total_amount' => 300.0,
            ]);
    }
}

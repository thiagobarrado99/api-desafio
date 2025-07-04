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
}

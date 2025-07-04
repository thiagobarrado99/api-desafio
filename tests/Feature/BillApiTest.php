<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Customer;
use Carbon\Carbon;

class BillApiTest extends TestCase
{
    use RefreshDatabase;

    // Test storing
    public function test_can_create_bill()
    {
        $customer = Customer::factory()->create();

        //Due date set to next week
        $due_date = now()->addWeek()->format('Y-m-d');

        // Create bill
        $response = $this->postJson('/api/bills', [
            'customer_id' => $customer->id,
            'amount' => 50.0,
            'due_date' => $due_date,
            'description' => 'Fatura teste',
        ]);

        //Check HTTP 201 (created)
        $response->assertStatus(201)
            ->assertJsonFragment([
                'customer_id' => $customer->id,
                'amount' => 50.0,
                'due_date' => $due_date,
                'description' => 'Fatura teste',
            ]);

    }
}

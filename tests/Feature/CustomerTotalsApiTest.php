<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Customer;
use Carbon\Carbon;

class CustomerTotalsApiTest extends TestCase
{
    use RefreshDatabase;

    // Test total bills sum for customer
    public function test_can_get_total_bills_for_customer_in_month()
    {
        $customer = Customer::factory()->create();

        $month_query = now()->addMonthNoOverflow()->format('Y-m');

        $first_due_date = now()->addMonthNoOverflow()->startOfMonth()->format('Y-m-d');
        $second_due_date = now()->addMonthNoOverflow()->startOfMonth()->addDays(2)->format('Y-m-d');

        $outside_due_date = now()->addMonthNoOverflow()->startOfMonth()->addMonths(2)->format('Y-m-d');

        // Create bills in the selected month (and another one outside, so it wont sum)
        $customer->bills()->createMany([
            [
                'amount' => 100,
                'description' => 'Fatura 1',
                'due_date' => $first_due_date,
            ],
            [
                'amount' => 200,
                'description' => 'Fatura 2',
                'due_date' => $second_due_date,
            ],
            [
                'amount' => 300,
                'description' => 'Fatura 3',
                'due_date' => $outside_due_date,
            ],
        ]);

        $response = $this->getJson("/api/customers/{$customer->id}/bills?month=$month_query");

        $response->assertStatus(200)
            ->assertJsonFragment([
                'name' => $customer->name,
                'month' => $month_query,
                'total_amount' => 300.0,
            ]);
    }
}
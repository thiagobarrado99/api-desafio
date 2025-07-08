<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerTotalRequest;
use App\Http\Requests\StoreCustomerRequest;
use App\Interfaces\CustomerRepositoryInterface;
use Illuminate\Support\Facades\Cache;
use App\Services\CustomerService;
use Carbon\Carbon;

use OpenApi\Attributes as OA;

class CustomerController extends Controller
{
    private CustomerRepositoryInterface $customers;

    public function __construct(CustomerRepositoryInterface $customers)
    {
        $this->customers = $customers;
    }

    #[OA\Get(
        path: '/customers',
        operationId: 'listCustomers',
        summary: 'List all customers',
        description: 'Returns a list of all customers.',
        tags: ['Customers'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'List of customers',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(
                        properties: [
                            new OA\Property(property: 'id', type: 'integer', example: 1),
                            new OA\Property(property: 'name', type: 'string', example: 'Thiago Souza'),
                            new OA\Property(property: 'tax_id', type: 'string', example: '12345678901'),
                            new OA\Property(property: 'email', type: 'string', format: 'email', example: 'thiago@example.com'),
                            new OA\Property(property: 'created_at', type: 'string', format: 'date-time'),
                            new OA\Property(property: 'updated_at', type: 'string', format: 'date-time'),
                        ]
                    )
                )
            )
        ]
    )]
    public function index(): mixed
    {
        return $this->customers->all();
    }

    #[OA\Post(
        path: '/customers',
        operationId: 'createCustomer',
        summary: 'Create a new customer',
        description: 'Creates a new customer with name, tax ID, and email.',
        tags: ['Customers'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name', 'tax_id', 'email'],
                properties: [
                    new OA\Property(property: 'name', type: 'string', maxLength: 150, example: 'Thiago Souza'),
                    new OA\Property(property: 'tax_id', type: 'string', maxLength: 14, pattern: '^\d+$', example: '12345678901'),
                    new OA\Property(property: 'email', type: 'string', format: 'email', maxLength: 256, example: 'thiago@example.com'),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Customer created successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'name', type: 'string'),
                        new OA\Property(property: 'tax_id', type: 'string'),
                        new OA\Property(property: 'email', type: 'string'),
                        new OA\Property(property: 'created_at', type: 'string', format: 'date-time'),
                        new OA\Property(property: 'updated_at', type: 'string', format: 'date-time'),
                    ]
                )
            ),
            new OA\Response(
                response: 422,
                description: 'Validation error'
            )
        ]
    )]
    public function store(StoreCustomerRequest $request): mixed
    {
        $data = $request->validated();
        $customer = $this->customers->create($data);
        return response()->json($customer, 201);
    }

    #[OA\Get(
        path: '/customers/{id}/bills',
        operationId: 'getCustomerMonthlyBillTotal',
        summary: 'Get total bill sum for a customer in a specific year-month',
        description: 'Returns the total sum of bills for a customer in the selected month.',
        tags: ['Customers'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                description: 'Customer ID',
                schema: new OA\Schema(type: 'integer', example: 1)
            ),
            new OA\Parameter(
                name: 'month',
                in: 'query',
                required: true,
                description: 'Month in YYYY-MM format',
                schema: new OA\Schema(type: 'string', pattern: '^\d{4}-\d{2}$', example: '2025-07')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Total sum of bills for the customer in the given month',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'customer',
                            type: 'object',
                            properties: [
                                new OA\Property(property: 'id', type: 'integer', example: 1),
                                new OA\Property(property: 'name', type: 'string', example: 'Thiago Souza'),
                                new OA\Property(property: 'tax_id', type: 'string', example: '12345678901'),
                                new OA\Property(property: 'email', type: 'string', format: 'email', example: 'thiago@example.com'),
                                new OA\Property(property: 'created_at', type: 'string', format: 'date-time'),
                                new OA\Property(property: 'updated_at', type: 'string', format: 'date-time'),
                            ]
                        ),
                        new OA\Property(property: 'month', type: 'string', example: '2025-07'),
                        new OA\Property(property: 'total_amount', type: 'number', format: 'float', example: 300.00),
                    ]
                )
            ),
            new OA\Response(
                response: 422,
                description: 'Validation error (e.g., customer not found, missing or invalid month query parameter)'
            )
        ]
    )]
    public function customerBills(CustomerTotalRequest $request, CustomerService $customerService, int $id): mixed
    {
        $month = $request->query('month');
        $customer = $this->customers->find($id);

        $cacheKey = "customer_{$id}_bills_{$month}";

        // Get from cache
        $cached = Cache::get($cacheKey);

        if (!is_null($cached)) {
            return response()->json([
                'customer' => $customer,
                'month' => $month,
                'total_amount' => $cached['total'],
                'calculated_at' => $cached['calculated_at'],
                'cached' => true,
            ]);
        }

        // Not cached, calculate now and store
        $total = $customerService->totalInMonth($customer, $month);
        $calculatedAt = Carbon::now()->toDateTimeString();

        Cache::put($cacheKey, [
            'total' => $total,
            'calculated_at' => $calculatedAt,
        ], now()->addDay()); // cache for a day

        return response()->json([
            'customer' => $customer,
            'month' => $month,
            'total_amount' => $total,
            'calculated_at' => $calculatedAt,
            'cached' => false,
        ]);
    }
}

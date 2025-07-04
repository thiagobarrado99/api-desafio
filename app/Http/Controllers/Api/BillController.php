<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBillRequest;
use App\Interfaces\BillRepositoryInterface;
use App\Notifications\BillNotification;
use App\Services\BillService;
use OpenApi\Attributes as OA;

class BillController extends Controller
{
    private BillRepositoryInterface $bills;

    public function __construct(BillRepositoryInterface $bills)
    {
        $this->bills = $bills;
    }

    #[OA\Post(
        path: '/bills',
        operationId: 'createBill',
        summary: 'Create a new bill',
        description: 'Creates a new bill for a specific customer.',
        tags: ['Bills'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['customer_id', 'amount', 'due_date'],
                properties: [
                    new OA\Property(
                        property: 'customer_id',
                        type: 'integer',
                        example: 1,
                        description: 'ID of the customer to bill'
                    ),
                    new OA\Property(
                        property: 'amount',
                        type: 'number',
                        format: 'float',
                        example: 199.99,
                        description: 'Bill amount'
                    ),
                    new OA\Property(
                        property: 'due_date',
                        type: 'string',
                        format: 'date',
                        example: '2025-07-20',
                        description: 'Due date (must be today or later)'
                    ),
                    new OA\Property(
                        property: 'description',
                        type: 'string',
                        maxLength: 512,
                        example: 'Monthly subscription bill',
                        description: 'Optional description of the bill'
                    ),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Bill created successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 10),
                        new OA\Property(property: 'customer_id', type: 'integer', example: 1),
                        new OA\Property(property: 'amount', type: 'number', format: 'float', example: 199.99),
                        new OA\Property(property: 'due_date', type: 'string', format: 'date', example: '2025-07-20'),
                        new OA\Property(property: 'description', type: 'string', example: 'Monthly subscription bill'),
                        new OA\Property(property: 'created_at', type: 'string', format: 'date-time'),
                        new OA\Property(property: 'updated_at', type: 'string', format: 'date-time'),
                    ]
                )
            ),
            new OA\Response(
                response: 422,
                description: 'Validation error (e.g., missing or invalid fields)'
            )
        ]
    )]
    public function store(StoreBillRequest $request, BillService $billService)
    {
        $data = $request->validated();
        $bill = $this->bills->create($data);

        $billService->createHistoric($bill, $request->getContent());
        $billService->notify($bill, new BillNotification([
            'id' => $bill->id,
            'amount' => $bill->amount,
        ]));

        return response()->json($bill, 201);
    }
}

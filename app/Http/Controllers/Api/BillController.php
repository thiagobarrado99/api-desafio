<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBillRequest;
use App\Interfaces\BillRepositoryInterface;
use App\Notifications\BillNotification;
use App\Services\BillService;

class BillController extends Controller
{
    private BillRepositoryInterface $bills;

    public function __construct(BillRepositoryInterface $bills)
    {
        $this->bills = $bills;
    }

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

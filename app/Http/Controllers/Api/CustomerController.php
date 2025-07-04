<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerTotalRequest;
use App\Http\Requests\StoreCustomerRequest;
use App\Interfaces\CustomerRepositoryInterface;
use App\Models\Customer;
use App\Services\BillService;
use App\Services\CustomerService;

class CustomerController extends Controller
{
    private CustomerRepositoryInterface $customers;

    public function __construct(CustomerRepositoryInterface $customers)
    {
        $this->customers = $customers;
    }

    public function index()
    {
        return $this->customers->all();
    }

    public function store(StoreCustomerRequest $request)
    {
        $data = $request->validated();
        $customer = $this->customers->create($data);
        return response()->json($customer, 201);
    }

    public function customerBills(CustomerTotalRequest $request, CustomerService $customerService, $id)
    {
        $month = $request->query('month');
        $customer = Customer::find($id);

        $total = $customerService->totalInMonth($customer, $month);

        return response()->json([
            'customer' => $customer,
            'month' => $month,
            'total_amount' => $total,
        ]);
    }
}

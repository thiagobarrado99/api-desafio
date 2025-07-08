<?php

use App\Http\Controllers\Api\BillController;
use App\Http\Controllers\Api\CustomerController;
use Illuminate\Support\Facades\Route;

Route::middleware('log.requests')->group(function () {
    Route::resource("customers", CustomerController::class, [
        'only' => ['index', 'store']
    ]);

    Route::get('customers/{id}/bills', [CustomerController::class, 'customerBills']);

    Route::resource("bills", BillController::class, [
        'only' => ['store']
    ]);
});

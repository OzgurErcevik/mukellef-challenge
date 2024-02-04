<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\TransactionService;

class TransactionController extends Controller
{
    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function addTransaction(Request $request)
    {
        return $this->transactionService->create($request);
    }
}

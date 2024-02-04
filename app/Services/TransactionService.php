<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Transaction;

class TransactionService
{
    public function create(Request $request)
    {
        $request->validate([
            'subscription_id'=>'required|integer',
            'price'=>'required|numeric|decimal:0,2'
        ]);

        $transaction = new Transaction();
        $transaction->user_id = $request->route('uid');
        $transaction->subscription_id = $request->input('subscription_id');
        $transaction->price = $request->input('price');

        $transaction->save();

        return response()->json([
            'message' => 'Transaction successfull',
            'data' => $transaction
        ],201);
    }
}
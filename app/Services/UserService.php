<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Subscription;
use App\Models\Transaction;

class UserService
{
    public function register(Request $request)
    {
        $request->validate([
            'name'=>'required|min:3|max:100',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6|max:100|confirmed'
        ]);

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password)
        ]);

        $token = $user->createToken('PersonalAccessToken');

        return response()->json([
            'message' => 'Registration successfull',
            'token'=> $token->plainTextToken,
            'user' => $user
        ],201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'=>'required|email',
            'password'=>'required|min:6|max:100'
        ]);

        $credentials = request(['email', 'password']);
        if (!auth()->attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized, check your email/password'
            ], 401);
        }

        $user = $request->user();
        $token = $user->createToken('PersonalAccessToken');

        return response()->json([
            'message' => 'Login successfull',
            'token' => $token->plainTextToken
        ]);
    }

    public function getDetails(Request $request)
    {
        $uid = $request->route('uid');
        //$user = Auth::user();
        //$id = Auth::id();
        $user = User::find($uid);
        $subscriptions = Subscription::where('user_id', $uid)->get();
        $transactions = Transaction::where('user_id', $uid)->get();

        return response()->json([
            'user' => $user,
            'subscriptions' => $subscriptions,
            'transactions' => $transactions
        ]);
    }
}
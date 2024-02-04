<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Subscription;

class SubscriptionService
{
    public function create(Request $request)
    {
        $request->validate([
            'renewed_at'=>'required|date_format:Y-m-d H:i:s',
            'expired_at'=>'required|date_format:Y-m-d H:i:s'
        ]);

        $subscription = new Subscription();
        $subscription->user_id = $request->route('uid');
        $subscription->renewed_at = $request->input('renewed_at');
        $subscription->expired_at = $request->input('expired_at');

        $subscription->save();

        return response()->json([
            'message' => 'Subscription successfull',
            'data' => $subscription
        ],201);
    }

    public function update(Request $request)
    {
        $request->validate([
            'renewed_at'=>'date_format:Y-m-d H:i:s',
            'expired_at'=>'date_format:Y-m-d H:i:s'
        ]);

        $uid = $request->route('uid');
        $sid = $request->route('sid');

        $subscription = Subscription::where('id', $sid)->where('user_id', $uid)->first();
        if ($subscription === null)
        {
          $message = "Subscription not found";
          $response_code = 404;
        }
        else
        {
          $update = false;
          if ($request->input('renewed_at') !== null)
          {
            $subscription->renewed_at = $request->input('renewed_at');
            $update = true;
          }
          if ($request->input('expired_at') !== null)
          {
            $subscription->expired_at = $request->input('expired_at');
            $update = true;
          }

          if ($update)
          {
            $subscription->save();
            $message = "Subscription updated successfully";
            $response_code = 200;
          }
          else
          {
            $message = "No changes made";
            $response_code = 200;
          }
        }

        return response()->json([
            'message' => $message,
            'data' => $subscription
        ],$response_code);
    }

    public function delete(Request $request)
    {
        $uid = $request->route('uid');
        $sid = $request->route('sid');

        $subscription = Subscription::where('id', $sid)->where('user_id', $uid)->first();
        if ($subscription === null)
        {
          $message = "Subscription not found";
          $response_code = 404;
        }
        else
        {
          $subscription->delete();
          $message = "Subscription deleted successfully";
          $response_code = 200;
        }

        return response()->json([
            'message' => $message
        ],$response_code);
    }
}
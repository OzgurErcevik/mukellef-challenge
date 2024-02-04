<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\SubscriptionService;

class SubscriptionController extends Controller
{
    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    public function subscribe(Request $request)
    {
        return $this->subscriptionService->create($request);
    }

    public function editSubscription(Request $request)
    {
        return $this->subscriptionService->update($request);
    }

    public function deleteSubscription(Request $request)
    {
        return $this->subscriptionService->delete($request);
    }
}

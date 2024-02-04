<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\Subscription;
use App\Models\Transaction;
use Carbon\Carbon;

class ProcessRenewals implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $subscriptions = Subscription::where('expired_at', '<', Carbon::now())->get();

        foreach ($subscriptions as $subscription)
        {
            $transaction = new Transaction();
            $transaction->user_id = $subscription->user_id;
            $transaction->subscription_id = $subscription->id;
            $transaction->price = config('constants.PRICE');
            $transaction->save();

            $subscription->renewed_at = now();
            $subscription->expired_at = now()->addMonth();
            $subscription->save();
        }
    }
}

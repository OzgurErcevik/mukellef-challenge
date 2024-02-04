<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Subscription;
use App\Models\Transaction;
use Carbon\Carbon;

class ProcessRenewals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-renewals';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Suresi sona eren abonelikleri otomatik odeme cekerek yeniliyor.';

    /**
     * Execute the console command.
     */
    public function handle()
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
        $this->info("Suresi gecen abonelikler otomatik odeme cekerek yenilendi.");
    }
}

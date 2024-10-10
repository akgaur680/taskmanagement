<?php

namespace Database\Seeders;

use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currenttime = Carbon::now()->format('Y-m-d H:i:s');

        Subscription::insert([
            [
                'name' => 'Task Management Subscription',
                'stripe_price_id' => 'price_1Q8F3sJAtbSTFaXNodKuQ7ei',
                'trial_days' => 5,
                'amount' => 200,
                'type' => 0,
                'enabled' => 1,
                'created_at' => $currenttime,
                'updated_at' => $currenttime,
            ],
            [
                'name' => 'Task Management Subscription Yearly',
                'stripe_price_id' => 'price_1Q8F6zJAtbSTFaXNCJkeiGci',
                'trial_days' => 5,
                'amount' => 2000,
                'type' => 0,
                'enabled' => 1,
                'created_at' => $currenttime,
                'updated_at' => $currenttime,
            ],
            [
                'name' => 'Task Management Subscription Lifetime',
                'stripe_price_id' => 'price_1Q8F7aJAtbSTFaXNpYyJpign',
                'trial_days' => 5,
                'amount' => 25000,
                'type' => 0,
                'enabled' => 1,
                'created_at' => $currenttime,
                'updated_at' => $currenttime,
            ]
        ]);
    }
}

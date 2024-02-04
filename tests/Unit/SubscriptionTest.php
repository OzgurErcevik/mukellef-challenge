<?php

namespace Tests\Unit;

use App\Post;
use Tests\TestCase;

class SubscriptionTest extends TestCase
{
    private $user_id = 1;
    private $subscription_id = 1;
    private $token = '6|FJ2me2eO2YTGcryI3tYeuuy8NpyWdpuw9k3cj2xC642b0593';

    public function test_can_create_subscription()
    {
        $data = [
            'renewed_at' => '2024-02-04 00:00:00',
            'expired_at' => '2024-03-04 00:00:00'
        ];

        $this->withHeaders([
            'Authorization' => 'Bearer '. $this->token,
            'Accept' => 'application/json'
            ])->post('/user/'.$this->user_id.'/subscription', $data)
            ->assertStatus(201);
    }

    public function test_can_update_subscription()
    {
        $data = [
            'renewed_at' => '2024-02-04 11:00:00',
            'expired_at' => '2024-03-04 11:00:00'
        ];

        $this->withHeaders([
            'Authorization' => 'Bearer '. $this->token,
            'Accept' => 'application/json'
            ])->put('/user/'.$this->user_id.'/subscription/'.$this->subscription_id, $data)
            ->assertStatus(200);
    }

    public function test_can_delete_subscription()
    {
        $this->withHeaders([
            'Authorization' => 'Bearer '. $this->token,
            'Accept' => 'application/json'
            ])->delete('/user/'.$this->user_id.'/subscription/'.$this->subscription_id)
            ->assertStatus(200);
    }
}

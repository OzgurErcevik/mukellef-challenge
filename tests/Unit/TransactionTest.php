<?php

namespace Tests\Unit;

use App\Post;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    private $user_id = 1;
    private $token = '6|FJ2me2eO2YTGcryI3tYeuuy8NpyWdpuw9k3cj2xC642b0593';

    public function test_can_create_transaction()
    {
        $data = [
            'subscription_id' => 1,
            'price' => 999
        ];

        $this->withHeaders([
            'Authorization' => 'Bearer '. $this->token,
            'Accept' => 'application/json'
            ])->post('/user/'.$this->user_id.'/transaction', $data)
            ->assertStatus(201);
    }
}

<?php

namespace Tests\Unit;

use App\Post;
use Tests\TestCase;

class UserTest extends TestCase
{

    private $user_id = 1;
    private $token = '6|FJ2me2eO2YTGcryI3tYeuuy8NpyWdpuw9k3cj2xC642b0593';

    public function test_register_validation()
    {
        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password1'
        ];

        $this->withHeaders(['Accept' => 'application/json'])
            ->post('/register', $data)
            ->assertStatus(422);
    }
    public function test_can_register()
    {
        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ];

        $this->withHeaders(['Accept' => 'application/json'])
            ->post('/register', $data)
            ->assertStatus(201);

        $this->assertDatabaseHas('users', [
            'name' => $data['name'],
            'email' => $data['email'],
        ]);
    }

    public function test_can_show_user_details()
    {
        $this->withHeaders([
            'Authorization' => 'Bearer '. $this->token,
            'Accept' => 'application/json'
            ])->get('/user/'.$this->user_id)
            ->assertStatus(200);

        /*$this->assertJsonStructure([
            'user' => [
                'id',
                'name',
                'email',
                'email_verified_at',
                'created_at',
                'updated_at'
            ],
            'subscriptions' => [
                '*' => [
                    'id',
                    'user_id',
                    'renewed_at',
                    'expired_at',
                    'created_at',
                    'updated_at'
                ]
            ],
            'transactions' => [
                '*' => [
                    'id',
                    'user_id',
                    'subscription_id',
                    'price',
                    'created_at',
                    'updated_at'
                ]
            ]
        ]);*/
    }
}

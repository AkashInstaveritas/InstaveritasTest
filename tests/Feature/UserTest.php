<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class UserTest extends TestCase
{
    /**
     * Test for a user login with credentials.
     *
     * @return void
     */
    public function test_for_a_user_login()
    {
        $credentials = [
            'email' => 'akashsingh@instaveritas.com',
            'password' => 'password'
        ];

        return $this->postJson('/api/login', $credentials)
                    ->assertStatus(200)
                    ->assertJson(['message' => "LogIn Successfull!"])
                    ->assertJsonStructure([
                        'message',
                        'data' => [
                            'id', 
                            'fullname',
                            'email',
                            'phone'
                        ],
                        'token'
                    ]);
    }

    /**
     * Test for a user login with wrong credentials.
     *
     * @return void
     */
    public function test_for_a_user_login_with_incorrect_credentials()
    {
        $wrongCredentials = [
            'email' => 'akashsingh@instaveritas.com',
            'password' => 1234567,
        ];

        return $this->postJson('/api/login', $wrongCredentials)
                    ->assertStatus(200)
                    ->assertJson(['message' => "Email or password is incorrect."]);
    }


    /**
     * Test for getting the profile of the authenticated user
     *
     * @return void
     */
    public function test_for_getting_user_profile()
    {
        $user = User::findorFail(1);

        return $this->actingAs($user, 'api')
                    ->getJson('/api/profile')
                    ->assertStatus(200)
                    ->assertJsonStructure([
                        'data' => [
                            'id',
                            'fullname',
                            'email',
                            'phone'
                        ]
                    ]);
    }
}

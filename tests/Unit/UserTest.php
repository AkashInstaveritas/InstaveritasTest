<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    private $user;

    public function setUp() :void
    {
        parent::setUp();

        $this->user = User::findorFail(1);
        $this->actingAs($this->user, 'api');
    }

    /**
     * A test to register a user
     *
     * @return void
     */
    public function test_to_register_a_user()
    {
        $data = [
            'name' => 'Akash Singh',
            'email' => 'akashsingh@gmail.com',
            'phone' => 8920871449,
            'password' => 'password',
            'password_confirmation' => 'password'
        ];

        $response =  $this->json('POST', '/api/register', $data);

        $response = $response->json();

        $this->assertEquals($response['status_code'], 201);
        $this->assertEquals($response['message'], 'Registration Successfull.');
    }

    /**
     * A test to get the user profile
     *
     * @return void
     */
    public function test_to_show_the_user_profile()
    {
        $response =  $this->json('GET', '/api/profile')->assertStatus(200);

        $response = $response->json();

        $this->assertArrayHasKey('data', $response);
        $this->assertEquals($response['data']['fullname'], $this->user->name);
        $this->assertEquals($response['data']['email'], $this->user->email);
        $this->assertEquals($response['data']['phone'], $this->user->phone);
    }

    /**
     * A test to register a user
     *
     * @return void
     */
    public function test_to_update_a_user()
    {
        $data = [
            'name' => 'Akash Singh',
            'email' => 'singh9800akash@gmail.com',
            'phone' => 8800879750,
        ];

        $response =  $this->patchJson('/api/profile/update', $data);

        $response = $response->json();

        $this->assertArrayHasKey('data', $response);
        $this->assertEquals($response['message'], 'Profile updated successfully.');
        $this->assertEquals($response['data']['fullname'], $data['name']);
        $this->assertEquals($response['data']['email'], $data['email']);
        $this->assertEquals($response['data']['phone'], $data['phone']);
    }
}

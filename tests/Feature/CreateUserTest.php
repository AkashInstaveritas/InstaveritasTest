<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A test for name validation column for registration of a user.
     *
     * @return void
     */
    public function test_it_requires_a_name()
    {
        $this->register(['name' => ' '])
             ->assertJsonValidationErrors('name');
    }

    /**
     * A test for email validation column for registration of a user.
     *
     * @return void
     */
    public function test_it_requires_a_valid_email()
    {
        $this->register(['email' => 'himanshu-pal'])
            ->assertStatus(422)
             ->assertJsonValidationErrors('email');
    }

    /**
     * A test for unique email validation column for registration of a user.
     *
     * @return void
     */
    public function test_it_requires_a_valid_unique_email()
    {
        $this->register(['email' => 'daniel.karianne@example.net'])
             ->assertJsonValidationErrors('email');
    }

    /**
     * A test for phone validation column for registration of a user.
     *
     * @return void
     */
    public function test_it_requires_a_valid_phone_number()
    {
        $this->register(['phone' => 'phone-number'])
             ->assertJsonValidationErrors('phone');
    }

    /**
     * A test for password column for registration of a user.
     *
     * @return void
     */
    public function test_it_requires_a_password()
    {
        $this->register(['password' => ' '])
             ->assertJsonValidationErrors('password');
    }

    /**
     * A test for password column for registration of a user.
     *
     * @return void
     */
    public function test_it_requires_a_valid_confirmed_password()
    {
        $this->register(['password_confirmation' => 'Something-else'])
             ->assertJsonValidationErrors('password');
    }


    /**
     * Mehtod for providing validated field and
     * also can be overrided with incorrect data.
     */
    protected function validFields($overrides = [])
    {
        return  array_merge([
            'name' => 'Himanshu Pal',
            'email' => 'himanshu@instaveritas.com',
            'phone' => 9560016344,
            'password' => 'password',
            'password_confirmation' => 'password'
        ], $overrides);
    }

    /**
     * Mehtod for using the api endpoint and
     * making a post request for registering a user.
     */
    protected function register($attributes = [])
    {
        $this->withExceptionHandling();

        return $this->json('POST', '/api/register', $this->validFields($attributes));
    }

    /**
     * A test for password column for registration of a user.
     *
     * @return void
     */
    public function test_to_register_a_new_user()
    {
        $this->register()
             ->assertSuccessful()
             ->assertJson(['message' => "Registration Successfull."]);
    }
}

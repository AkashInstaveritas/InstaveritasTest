<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UpdateUserTest extends TestCase
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
     * A test for validation of name column for updating an autheticated user.
     *
     * @return void
     */
    public function test_it_requires_a_name()
    {
        $this->update(['name' => ' '])
             ->assertJsonValidationErrors('name');
    }

    /**
     * A test for validation of email column for updating an autheticated user.
     *
     * @return void
     */
    public function test_it_requires_a_valid_email()
    {
        $this->update(['email' => 'some-random-email'])
             ->assertJsonValidationErrors('email');
    }

    /**
     * A test for validation of email column for updating an autheticated user.
     *
     * @return void
     */
    public function test_it_requires_an_unique_unused_email()
    {
        $this->update(['email' => 'singh9800akash@gmail.com'])
             ->assertJsonValidationErrors('email');
    }

    /**
     * A test for validation of email column for updating an autheticated user.
     *
     * @return void
     */
    public function test_it_requires_a_valid_phone()
    {
        $this->update(['phone' => 'some-random-phone'])
             ->assertJsonValidationErrors('phone');
    }

    /**
     * A test for validation of email column for updating an autheticated user.
     *
     * @return void
     */
    public function test_it_requires_a_confirmed_password()
    {
        $this->update(['password_confirmation' => 'some-other-password'])
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
    protected function update($attributes = [])
    {
        $this->withExceptionHandling();

        return $this->actingAs($this->user, 'api')
                    ->patchJson('/api/profile/update', $this->validFields($attributes));
    }

    /**
     * A test for password column for registration of a user.
     *
     * @return void
     */
    public function test_to_update_an_existing_user()
    {
        $this->update()
             ->assertok()
             ->assertJson(['message' => "Profile updated successfully."]);
    }


}

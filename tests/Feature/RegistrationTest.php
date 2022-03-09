<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Test that the registration page can be viewed
     * 
     * @test
     * @return void
     */
    public function can_view_registration_page(): void
    {

        $response = $this->get(route('registration_form'));

        $response->assertOk();

        $response->assertSee('action="' . route('register') . '"', false);
        $response->assertSee('name="email"', false);
        $response->assertSee('name="name"', false);
        $response->assertSee('name="password"', false);
        $response->assertSee('name="password_confirmation"', false);
        $response->assertSee('type="submit"', false);

    }

    /**
     * Can register with valid information
     *
     * @test
     * @return void
     */
    public function can_register_with_valid_information(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'user',
            'email' => 'user@website.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect();

        $user = \App\Models\User::where('email', 'user@website.com')->first();

        $this->assertNotEmpty($user);
        $this->assertEquals($user->email, 'user@website.com');
    }

    /**
     * Test that the name field of the registration form is validated
     *
     * @test
     * @return void
     */
    public function name_field_of_registration_form_is_validated(): void
    {
        $response = $this->postJson(route('register'), []);

        $responseJson = $response->json();

        $this->assertArrayHasKey('errors',
            $responseJson,
            'No error found when name is omitted!'
        );
        $this->assertArrayHasKey('name', $responseJson['errors']);

        $response2 = $this->postJson(route('register'), [
            'name' => 'a',
        ]);

        $responseJson2 = $response2->json();

        $this->assertArrayHasKey('errors', $responseJson2);
        $this->assertArrayHasKey(
            'name',
            $responseJson2['errors'],
            'No error found when name is less than 3 characters!'
        );

        $response3 = $this->postJson(route('register'), [
            'name' => '123',
        ]);

        $responseJson3 = $response3->json();

        $this->assertArrayHasKey(
            'errors',
            $responseJson3,
            'No error found when name contains characters different from alphabets or space'
        );
        $this->assertArrayHasKey('name', $responseJson3['errors']);

        $response4 = $this->postJson(route('register'), [
            'name' => $this->faker->sentences(100, true),
        ]);

        $responseJson4 = $response4->json();

        $this->assertArrayHasKey(
            'errors',
            $responseJson4,
            'No error found when name longer than 100 characters different from alphabets or space'
        );
        $this->assertArrayHasKey('name', $responseJson4['errors']);

    }

    /**
     * Test that the email field of the registration form is validated
     *
     * @test
     * @return void
     */
    public function email_field_of_registration_form_is_validated(): void
    {
        $response = $this->postJson(route('register'), []);

        $responseJson = $response->json();

        $this->assertArrayHasKey('errors',
            $responseJson,
            'No error found when email is omitted!'
        );
        $this->assertArrayHasKey('email', $responseJson['errors']);

        $response2 = $this->postJson(route('register'), [
            'email' => 'a',
        ]);

        $responseJson2 = $response2->json();

        $this->assertArrayHasKey('errors', $responseJson2);
        $this->assertArrayHasKey(
            'email',
            $responseJson2['errors'],
            'No error found when email is not valid!'
        );

    }

    /**
     * Test that the password field of the registration form is validated
     *
     * @test
     * @return void
     */
    public function password_field_of_registration_form_is_validated(): void
    {
        // Check password required
        $response = $this->postJson(route('register'), []);

        $responseJson = $response->json();

        $this->assertArrayHasKey('errors',
            $responseJson,
            'No error found when password fields are omitted!'
        );
        $this->assertArrayHasKey('password', $responseJson['errors']);

        // Check password length
        $response2 = $this->postJson(route('register'), [
            'password' => 'a',
        ]);

        $responseJson2 = $response2->json();

        $this->assertArrayHasKey('errors', $responseJson2);
        $this->assertArrayHasKey(
            'password',
            $responseJson2['errors'],
            'No error found when password is less than 6 characters!'
        );

        // Check password confirmed
        $response3 = $this->postJson(route('register'), [
            'password' => '123456',
            'password_confirmaton' => 'q',
        ]);

        $responseJson3 = $response3->json();

        $this->assertArrayHasKey('errors', $responseJson3);
        $this->assertArrayHasKey(
            'password',
            $responseJson3['errors'],
            'No error found when password is not confirmed!'
        );

    }
}

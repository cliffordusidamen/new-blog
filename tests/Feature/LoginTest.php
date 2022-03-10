<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that login page is accessible
     *
     * @test
     * @return void
     */
    public function can_view_login_page(): void
    {
        $response = $this->get(route('login'));
    
        $response->assertOk();

        $response->assertSee('action="' . route('authenticate') . '"', false);
        $response->assertSee('name="email"', false);
        $response->assertSee('name="password"', false);
        $response->assertSee('name="_token"', false);
    }

    /**
     * Test that visitor cannot login with invalid credentials
     *
     * @test
     * @return void
     */
    public function visitor_cannot_login_with_wrong_credentials(): void
    {
        $user = \App\Models\User::factory()->create([]);

        $response = $this->post(route('authenticate'), [
            'email' => $user->email,
            'password' => 'wrong_password',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors('email');
    }

    /**
     * Test that a visitor can login with valid credentials
     *
     * @test
     * @return void
     */
    public function visitor_can_login_with_valid_credentials(): void
    {
        $user = \App\Models\User::factory()->state([
            'password' => 'password',
        ])->create([]);

        $response = $this->post(route('authenticate'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('my_posts'));
    }

    /**
     * Test that user cannot view login page if already logged in
     *
     * @test
     * @return void
     */
    public function user_cannot_view_login_page(): void
    {
        $user = \App\Models\User::create([
            'name' => 'user',
        ]);
        $response = $this->actingAs($user)->get(route('login'));

        $response->assertRedirect();
    }
}

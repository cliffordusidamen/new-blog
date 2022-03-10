<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogoutTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Test that the guest cannot see the logout link
     *
     * @test
     * @return void
     */
    public function guest_cannot_see_logout_link(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertDontSee('logout');
        $response->assertDontSee('action="' . route('login') . '"', false);
    }

    /**
     * User can see the logout link
     *
     * @test
     * @return void
     */
    public function user_can_see_logout_link(): void
    {
        $user = \App\Models\User::create([
            'name' => 'John Doe',
        ]);

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
        $response->assertSee('action="' . route('logout') . '"', false);
        $response->assertDontSee('action="' . route('login') . '"', false);
    }

    /**
     * User can logout
     *
     * @test
     * @return void
     */
    public function user_can_logout(): void
    {
        $user = \App\Models\User::create([
            'name' => 'John Doe',
        ]);

        $response = $this->actingAs($user)->post(route('logout'));
        $response->assertRedirect(route('login'));
    }
}

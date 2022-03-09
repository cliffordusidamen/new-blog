<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostViewTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a user can view a post
     * 
     * @test
     * @return void
     */
    public function can_view_post()
    {
        $user = \App\Models\User::factory()->create([]);
        $post = $user->posts()->create([
            'title' => 'Sample title',
            'description' => 'Sample description',
            'publication_date' => '2022-03-04',
        ]);

        $response = $this->get("/posts/{$post->id}");

        $response->assertSee('Sample title');
        $response->assertSee('Sample description');
        $response->assertSee($user->name);
        $response->assertSee('4th March, 2022');

        $response->assertStatus(200);
    }

}

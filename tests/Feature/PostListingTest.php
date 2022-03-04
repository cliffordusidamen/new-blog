<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostListingTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a user can view the posts listing page
     *
     * @test
     * @return void
     */
    public function test_can_view_posts_listing()
    {
        $user = \App\Models\User::factory()->create();
        $firstPost = \App\Models\Post::factory()->state([
            'title' => 'Hisfirst post',
        ])
        ->for($user)
        ->create();

        $secondPost = \App\Models\Post::factory()->state([
            'title' => 'His second post',
        ])
        ->for($user)
        ->create();
        
        $response = $this->get('/posts');

        $response->assertStatus(200);
        $response->assertSee($firstPost->title);
        $response->assertSee($secondPost->title);
        $response->assertSee($user->name);
    }
}

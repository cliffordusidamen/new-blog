<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PersonalPostsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Guest cannot view personal post listing
     *
     * @test
     * @return void
     */
    public function guest_cannot_view_personal_posts_listing(): void
    {
        $response = $this->get('/my-posts');
        $response->assertRedirect(route('login'));
    }

    /**
     * Test can view listing of personal posts
     *
     * @test
     * @return void
     */
    public function user_can_view_personal_posts_listing()
    {
        $user = \App\Models\User::factory()->create();
        $firstPost = \App\Models\Post::factory()->state([
            'title' => 'Hisfirst post',
        ])
        ->for($user)
        ->create();

        $response = $this->actingAs($user)->get('/my-posts');

        $response->assertOk();
        $response->assertSee($firstPost->title);
    }

    /**
     * Test that user can only see own posts in personal posts listing
     *
     * @test
     * @return void
     */
    public function user_can_see_only_personal_posts(): void
    {
        $user = \App\Models\User::create([
            'name' => 'user'
        ]);
        $myPost = \App\Models\Post::factory()->state([
            'title' => 'Hisfirst post',
        ])
        ->for($user)
        ->create();

        $otherPost = Post::factory()->for(User::factory())->create();

        $response = $this->actingAs($user)->get('/my-posts');

        $response->assertOk();
        $response->assertSee($myPost->title);
        $response->assertDontSee($otherPost->title);
    }

    /**
     * Test that use can view personal post
     *
     * @test
     * @return void
     */
    public function can_veiw_personal_post(): void
    {
        $user = User::create([
            'name' => 'user',
        ]);

        $myPost = \App\Models\Post::factory()
            ->for($user)
            ->create();

        $response = $this->actingAs($user)->get(route('my_posts.show', $myPost));

        $response->assertOk();
        $response->assertSee($myPost->title);
        $response->assertSee($myPost->description);
    }

    /**
     * Test that use cannot view personal post
     *
     * @test
     * @return void
     */
    public function cannot_veiw_other_post_as_personal_post(): void
    {
        $user = User::create([
            'name' => 'user',
        ]);

        $otherPost = \App\Models\Post::factory()
            ->for(User::factory())
            ->create();

        $response = $this->actingAs($user)->get(route('my_posts.show', $otherPost));

        $response->assertNotFound();
    }
}

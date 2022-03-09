<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostCreationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Guest cannot view post creation post
     * 
     * @test
     * @return void
     */
    public function guest_cannot_view_post_creation_page(): void
    {
        $response = $this->get(route('posts.create'));
        $response->assertRedirect(route('login'));
    }

    /**
     * Test user can view post creation page
     *
     * @test
     * @return void
     */
    public function user_can_view_post_creation_page()
    {
        $user = User::create(['name' => 'user']);
        $response = $this->actingAs($user)
            ->get(route('posts.create'));

        $response->assertOk();
        $response->assertSee('name="title"', false);
        $response->assertSee('name="description"', false);
        $response->assertSee('name="_token"', false);
    }

    /**
     * User can create a new post by submitting/sending valid data
     *
     * @test
     * @return void
     */
    public function user_can_create_post_with_valid_data(): void
    {
        $user = User::create(['name' => 'user']);
        $response = $this->actingAs($user)->post(route('posts.store'), [
            'title' => 'title',
            'description' => 'description',
        ]);

        $response->assertRedirect(route('my_posts'));

        $post = Post::where('title', 'title')->first();

        $this->assertNotEmpty($post);
        $this->assertNotEmpty($post->id);
    }


    /**
     * Test that the title field of the creation form is validated
     *
     * @test
     * @return void
     */
    public function title_field_is_validated(): void
    {
        $user = User::create(['name' => 'user']);

        // Title field not present
        $response = $this->actingAs($user)->postJson(route('posts.store'), []);
        $responseJson = $response->json();
        $this->assertArrayHasKey('errors',
            $responseJson,
            'No error found when title is not present!'
        );
        $this->assertArrayHasKey('title', $responseJson['errors']);

        // Title less than 3 characters
        $response2 = $this->actingAs($user)->postJson(route('posts.store'), [
            'title' => 'ab',
        ]);
        $response2Json = $response2->json();
        $this->assertArrayHasKey('title', $response2Json['errors']);
    }

    /**
     * Test that the description field of the creation form is validated
     *
     * @test
     * @return void
     */
    public function description_field_is_validated(): void
    {
        $user = User::create(['name' => 'user']);

        // description field not present
        $response = $this->actingAs($user)->postJson(route('posts.store'), []);
        $responseJson = $response->json();
        $this->assertArrayHasKey('errors',
            $responseJson,
            'No error found when description is not present!'
        );
        $this->assertArrayHasKey('description', $responseJson['errors']);

        // description less than 3 characters
        $response2 = $this->actingAs($user)->postJson(route('posts.store'), [
            'description' => 'ab',
        ]);
        $response2Json = $response2->json();
        $this->assertArrayHasKey('description', $response2Json['errors']);
    }
    
}

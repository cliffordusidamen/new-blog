<?php

namespace Tests\Unit\Services;

use App\Models\Post;
use App\Models\User;
use App\Services\PostFeedService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PostFeedServiceTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Http::fake([
            PostFeedService::API_URL => Http::response([
                'data' => [
                    [
                        'title' => "title",
                        'description' => "description",
                        'publication_date' => "2022-03-04 12:00:00",
                    ],
                ],
            ])
        ]);
    }

    /**
     * Test that service can fetch posts using other blog API
     *
     * @test
     * @return void
     */
    public function can_fetch_posts_using_blog_api(): void
    {
        $postFeedService = new PostFeedService();
        $posts = $postFeedService->fetchPosts();

        $this->assertTrue(count($posts) > 0);
    }

    /**
     * Test that an admin user is created
     * when saving posts from blog API
     *
     * @test
     * @return void
     */
    public function admin_user_is_created_when_saving_posts_feed(): void
    {
        $postFeedService = new PostFeedService();
        $postFeedService->feedPostToDatabase();
        $adminUser = User::where('is_admin', true)->first();

        $this->assertNotNull($adminUser);
        $this->assertTrue((bool) $adminUser->is_admin);
    }

    /**
     * Test that the posts from blog API are saved to the database
     * as belonging to the the admin user
     *
     * @test
     * @return void
     */
    public function posts_feed_is_saved_as_admin_posts(): void
    {
        $postFeedService = new PostFeedService();
        $postsBefore = Post::all();

        $postFeedService->feedPostToDatabase();
        $postsAfter = Post::all();
        $adminUser = User::where('is_admin', true)->first();
        $adminPosts = $adminUser->posts;

        $this->assertEquals($postsBefore->count(), 0);

        $this->assertEquals(
            array_column($postsAfter->toArray(), 'id'),
            array_column($adminPosts->toArray(), 'id')
        );
    }
}

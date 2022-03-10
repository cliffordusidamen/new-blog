<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostSortingTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Test that the posts are sorted in descending order
     * of publication date by default
     *
     * @test
     * @return void
     */
    public function post_sorted_in_descending_order_of_publication_dates():void
    {
        $user = User::factory()->create();
        $post1 = Post::factory()->for($user)->create(['publication_date' => '2020-01-01']);
        $post2 = Post::factory()->for($user)->create(['publication_date' => '2020-01-02']);
        $post3 = Post::factory()->for($user)->create(['publication_date' => '2020-01-03']);

        $response = $this->getJson('/posts?order=desc');

        $response->assertStatus(200);
        $responseJson = $response->json();

        $this->assertEquals(
            [
                $post3->id,
                $post2->id,
                $post1->id,
            ],
            array_column($responseJson['data'], 'id')
        );
    }

    /**
     * Test that user can sort posts by publication date
     * in ascending order
     *
     * @test
     * @return void
     */
    public function can_sort_posts_by_publication_date_in_ascending_order()
    {
        $user = User::factory()->create();
        $firstPost = Post::factory()
            ->for($user)
            ->create([
                'title' => 'First post',
                'publication_date' => '2020-01-01',
            ]);

        $secondPost = Post::factory()
            ->for($user)
            ->create([
                'title' => 'Second post',
                'publication_date' => '2020-01-02',
            ]);

        $response = $this->getJson(
            route(
                'posts.index',
                [
                    'order' => 'oldest',
                ]
            )
        );

        $response->assertStatus(200);
        $responseJson = $response->json();

        $this->assertEquals(
            [
                $firstPost->id,
                $secondPost->id,
            ],
            array_column($responseJson['data'], 'id')
        );
    }
}

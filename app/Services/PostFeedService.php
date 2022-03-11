<?php

namespace App\Services;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class PostFeedService
{
    const API_URL = 'https://sq1-api-test.herokuapp.com/posts';

    /**
     * Fetch the posts using the API_URL
     *
     * @return array
     */
    public function fetchPosts(): array
    {
        $response = Http::get(self::API_URL);

        if ($response->status() !== 200) {
            return [];
        }

        return $response->json()['data'] ?? [];
    }

    /**
     * Save posts from the API_URL to the database
     *
     * @return void
     */
    public function feedPostToDatabase(): void
    {
        $posts = $this->fetchPosts();

        if (empty($posts)) {
            return;
        }
        $adminUser = User::getAdminUser();

        $posts = collect($posts)->map(fn($post) => (
            [
                ...$post,
                'user_id' => $adminUser->id,
            ]
        ))
        ->toArray();

        $adminUser->posts()->upsert(
            $posts,
            ['title', 'user_id'],
            ['description', 'publication_date']
        );
    }
}

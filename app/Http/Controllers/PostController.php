<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class PostController extends Controller
{

    /**
     * List all posts
     *
     * @return View
     */
    public function index(): View
    {
        $posts = Post::all();

        return view('posts.index', compact('posts'));
    }
    /**
     * Show post page
     *
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function show(string $slug): View
    {
        $post = \App\Models\Post::where('slug', $slug)->firstOrFail();
        return view('posts.show', compact('post'));
    }
}

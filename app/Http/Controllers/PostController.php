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
     * @param string $id
     * @return \Illuminate\View\View
     */
    public function show(string $id): View
    {
        $post = \App\Models\Post::findOrFail((int) $id);
        return view('posts.show', compact('post'));
    }

    /**
     * Personal posts listing page
     * 
     * @return View
     */
    public function myPosts(Request $request): View
    {
        $posts = $request->user()->posts()->paginate(10);

        return view('posts.my_posts', compact('posts'));
    }
}

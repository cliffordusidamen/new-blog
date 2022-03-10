<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class PostController extends Controller
{

    /**
     * List all posts
     *
     * @param  \Illuminate\Http\Request  $request
     * @return View|JsonResponse
     */
    public function index(
        Request $request
    ): View|JsonResponse
    {
        $order = $request->query('order');
        $order = $order === 'oldest' ? 'asc' : 'desc';

        $posts = Post::orderBy('publication_date', $order)
            ->paginate(10);

        if ($request->wantsJson()) {
            return response()->json($posts);
        }

        return view('posts.index', compact('posts', 'order'));
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

    /**
     * View personal post
     *
     * @param string $id
     * @param Request $request
     * @return View
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function showMyPost(
        string $id,
        Request $request
    ): View {
        $post = $request->user()->posts()->findOrFail((int) $id);
        return view('posts.show_my_post' , compact('post'));
    }

    /**
     * Display form for creating a post
     *
     * @return View
     */
    public function showPostCreationForm(): View
    {
        return view('posts.create');
    }

    /**
     * Save new post to database
     *
     * @param StorePostRequest $request
     * @return RedirectResponse
     */
    public function storePost(
        StorePostRequest $request
    ): RedirectResponse {

        $data = collect($request->validated())
            ->only(['title', 'description'])
            ->toArray();
        $data['publication_date'] = \Carbon\Carbon::now();

        $post = $request
            ->user()
            ->posts()
            ->create($data);

        if ($post) {
            return redirect()->route('my_posts')->with([
                'status' => 'success',
                'message' => 'Post created successfully!',
            ]);
        }

        return redirect()->route('posts.create')
            ->withInput()
            ->with([
                'status' => 'warning',
                'message' => 'Post was not created! Please, try again.',
            ]);
    }
}

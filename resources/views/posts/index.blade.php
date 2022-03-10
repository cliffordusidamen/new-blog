<x-layouts.default>
    <div class="d-flex justify-content-space-between">
        <h4>Posts</h4>

        <div class="text-end">
            Order:
            <form method="GET" id="#frm-sort" action="{{ route('posts.index') }}">
                <select name="order" onchange="this.form.submit()">
                    <option value="latest" {{ $order === 'desc' ? 'selected' : '' }}>
                        Newest
                    </option>
                    <option value="oldest" {{ $order === 'asc' ? 'selected' : '' }}>
                        Oldest
                    </option>
                </select>
            </form>
        </div>
    </div>
    @forelse ($posts as $post)
        <p class="post-list-item ">
            <a href="{{ route('posts.show', ['id' => $post->id]) }}">
                {{ $post->title }}
            </a>
            <br />
            <small>
                By {{ $post->user->name }}
                {{ \Carbon\Carbon::parse($post->publication_date)->format('jS F, Y - g:iA') }}
            </small>
        </p>
    @empty
        <p>No post available!</p>
    @endforelse

    @if ($posts->count() > 0 && $posts->lastPage() > 1)
        <div class="">
            {{ $posts->withQueryString()->links() }}
        </div>
    @endif
</x-layouts.default>
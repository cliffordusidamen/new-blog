<x-layouts.default>
    <h4>My Posts</h4>
    @forelse ($posts as $post)
        <p class="post-list-item ">
            <a href="{{ route('posts.show', ['id' => $post->id]) }}">
                {{ $post->title }}
            </a>
            <br />
            <small>
                {{ \Carbon\Carbon::parse($post->publication_date)->format('jS F, Y - g:iA') }}
            </small>
        </p>
    @empty
        <p>No post available!</p>
    @endforelse
</x-layouts.default>
<x-layouts.default>
    <h4>New Post</h4>
    <form action="{{ route('posts.store') }}" method="post">
        @csrf
        <div>
            <label for="title">Title</label><br />
            <input type="text" name="title" id="title" value="{{ old('title') }}" required />
            @error('title')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="description">Description</label><br />
            <textarea name="description" id="description" rows="5" required>
                {{ old('description') }}
            </textarea>
            @error('description')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <button type="submit">SUBMIT</button>
        </div>
    </form>
</x-layouts.default>
@extends('layouts.default')

@section('content')
<h4>
    {{ $post->title }}
    <small>
        By {{ $post->user->name }}
        {{ \Carbon\Carbon::parse($post->publication_date)->format('jS F, Y - g:iA') }}
    </small>
</h4>
<div>{{ $post->description }}</div>
@endsection
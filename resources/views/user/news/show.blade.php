@extends('layouts.app')

@section('content')
    <h1>{{ $news->title }}</h1>

    <div class="text-center">
        @if ($news->image)
            <a href="{{ asset('storage/images/' . $news->image) }}"><img class="post-image"
                    src="{{ asset('storage/images/' . $news->image) }}" alt="{{ $news->title }}"></a>
        @endif
    </div>

    <p>{{ $news->content }}</p>
    <p><strong>Author:</strong> {{ $news->author }}</p>

    <!-- Display Comments -->
    <h2>Comments</h2>
    @foreach ($news->comments as $comment)
        <div>
            <p><strong>{{ $comment->user->name }}</strong>: {{ $comment->content }}</p>

            @if (auth()->check() && auth()->user()->id == $comment->user_id)
                <a href="{{ route('comments.edit', $comment->id) }}" class="btn btn-secondary btn-sm">Edit</a>
                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            @endif
            <p><small>Posted on: {{ $comment->created_at->format('M d, Y') }}</small></p>
        </div>
    @endforeach

    <!-- Add Comment Form -->
    @auth
        <form action="{{ route('comments.store', $news->id) }}" method="POST">
            @csrf
            <div>
                <label for="content">Add a comment:</label>
                <textarea name="content" id="content" rows="3" required></textarea>
            </div>
            <button type="submit">Submit</button>
        </form>
    @else
        <p>Please <a href="{{ route('login') }}">login</a> to add a comment.</p>
    @endauth

    <a href="/">Back</a>
@endsection

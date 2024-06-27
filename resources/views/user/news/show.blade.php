@extends('layouts.app')

@section('content')
    <div class="show-container">
        <div class="back-button-container">
            <a href="/" class="back-button">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
        <h1>{{ $news->title }}</h1>

        <div class="text-center">
            @if ($news->image)
                <a href="{{ asset('storage/images/' . $news->image) }}"><img class="post-image"
                        src="{{ asset('storage/images/' . $news->image) }}" alt="{{ $news->title }}"></a>
            @endif
        </div>

        <p>{{ $news->content }}</p>
        <p><strong>Author:</strong> {{ $news->author }}</p>

        @auth
        <form id="favorite-form" action="{{ route('news.favorite', ['id' => $news->id]) }}" method="POST">
            @csrf
            <button class="favorite-button" id="favorite-button" data-id="{{ $news->id }}">
                <span class="icon">&#x2764;</span> <!-- Unicode heart icon -->
                Add to Favorites
            </button>
        </form>
        @endauth


        <!-- Display Comments -->
        <h2>Comments</h2>
        @foreach ($news->comments as $comment)
            <div class="comment">
                <p><strong>{{ $comment->user->name }}</strong>: {{ $comment->content }}</p>

                @if (auth()->check() && auth()->user()->id == $comment->user_id)
                    <div class="comment-actions">
                        <a href="{{ route('comments.edit', $comment->id) }}" class="edit-button">Edit</a>
                        <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-button">Delete</button>
                        </form>
                    </div>
                @endif
                <p><small>Posted on: {{ $comment->created_at->format('M d, Y') }}</small></p>
            </div>
        @endforeach

        <!-- Add Comment Form -->
        @auth
            <div class="add-comment">
                <form action="{{ route('comments.store', $news->id) }}" method="POST">
                    @csrf
                    <div>
                        <label for="content">Add a comment:</label>
                        <textarea name="content" id="content" rows="3" class="comment-box" required></textarea>
                    </div>
                    <button type="submit" class="submit-button">Submit</button>
                </form>
            </div>
        @else
            <p>Please <a href="{{ route('login') }}">login</a> to add a comment.</p>
        @endauth
    </div>
@endsection

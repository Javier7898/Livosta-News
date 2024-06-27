@extends('layouts.app')

@section('content')
<div class="container">
    <div class="back-button-container">
        <a href="/" class="back-button">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
    <h1>Favorites</h1>
    @if ($favorites->count() > 0)
        <div class="news-grid">
            @foreach ($favorites as $item)
                <div class="news-card">
                    <img src="{{ asset('storage/images/' . $item->image) }}" alt="{{ $item->title }}">
                    <div class="news-card-content">
                        <span class="category-label">{{ $item->category->name }}</span>
                        <h3>{{ $item->title }}</h3>
                        <p>{{ \Illuminate\Support\Str::limit($item->content, 150, $end='...') }}</p>
                        <p class="author">By {{ $item->author }}</p>
                        <p class="created-at">Created at: {{ $item->created_at->format('d F Y H:i') }}</p>
                        <div class="button-container">
                            <a href="{{ route('news.show', $item->id) }}" class="btn btn-primary">Read More</a>
                            <form action="{{ route('news.unfavorite', $item->id) }}" method="POST" class="form-unfavorite">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-unfavorite">Unfavorite</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="pagination-container">
            {{ $favorites->links() }}
        </div>
    @else
        <p>You have no favorite news.</p>
    @endif
</div>
@endsection

@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<div class="container">
    <h1 class="page-title">Search Result</h1>

    <!-- News Grid -->
    <div class="news-grid">
        @if ($news->count() > 0)
            @foreach ($news as $item)
                <div class="news-card">
                    <img src="{{ asset('storage/images/' . $item->image) }}" alt="{{ $item->title }}">
                    <div class="news-card-content">
                        <span class="category-label">{{ $item->category->name }}</span>
                        <h3>{{ $item->title }}</h3>
                        <p>{{ \Illuminate\Support\Str::limit($item->content, 150, $end='...') }}</p>
                        <p class="author">By {{ $item->author }}</p>
                        <a href="{{ route('news.show', ['id' => $item->id]) }}" class="read-more">Read More</a>
                    </div>
                </div>
            @endforeach
        @else
            <p>{{ __('No news found.') }}</p>
        @endif
    </div>
</div>
@endsection

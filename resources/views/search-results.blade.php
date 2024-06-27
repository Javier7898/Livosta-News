@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<div class="container">
    <div class="show-container">
        <div class="back-button-container">
            <a href="/" class="back-button">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
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
        
        <!-- Pagination -->
        <div class="pagination-container">
            @if ($news->hasPages())
                <nav aria-label="Pagination">
                    <ul class="pagination justify-content-between">
                        {{-- Previous Page Link --}}
                        @if ($news->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">&laquo; Previous</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a href="{{ $news->appends(request()->query())->previousPageUrl() }}" class="page-link" rel="prev">&laquo; Previous</a>
                            </li>
                        @endif

                        {{-- Next Page Link --}}
                        @if ($news->hasMorePages())
                            <li class="page-item">
                                <a href="{{ $news->appends(request()->query())->nextPageUrl() }}" class="page-link" rel="next">Next Page &raquo;</a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link">Next Page &raquo;</span>
                            </li>
                        @endif
                    </ul>
                </nav>
            @endif
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<div class="container">
    <h1 class="page-title">Livosta News</h1>

    <!-- Highlighted News -->
    @if ($highlightedNews)
        <div class="highlighted-news mb-5">
            <h2>{{ $highlightedNews->title }}</h2>
            <img src="{{ asset('storage/images/' . $highlightedNews->image) }}" alt="{{ $highlightedNews->title }}">
            <p class="author">By <i>{{ $highlightedNews->author }}</i></p>
            <a href="{{ route('news.show', ['id' => $highlightedNews->id]) }}" class="read-more">Read More</a>
            <!-- Pin Icon -->
            <span class="pin-icon"><i class="fas fa-thumbtack"></i></span>
            
            <!-- Unhighlight Button (Admin Only) -->
            @auth
                @if (auth()->user()->is_admin)
                    <form method="POST" action="{{ route('news.unhighlight', ['id' => $highlightedNews->id]) }}" class="mt-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">Unhighlight</button>
                    </form>
                @endif
            @endauth
        </div>
    @endif

    <!-- Search Form -->
    <div class="filter-options mb-3">
        <form method="GET" action="{{ route('news.search') }}">
            <div class="form-group row">
                <label for="search" class="col-md-2 col-form-label text-md-right">{{ __('Search') }}</label>
                <div class="col-md-4">
                    <input id="search" type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Search news...">
                </div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary">{{ __('Search') }}</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Filter and Sort Options -->
    <div class="filter-options mb-3">
        <form method="GET" action="{{ route('news.index') }}">
            <div class="form-group row">
                <label for="category" class="col-md-2 col-form-label text-md-right">{{ __('Category') }}</label>
                <div class="col-md-4">
                    <select id="category" name="category" class="form-control">
                        <option value="all" {{ request('category', 'all') == 'all' ? 'selected' : '' }}>All Categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <label for="sort" class="col-md-2 col-form-label text-md-right">{{ __('Sort By') }}</label>
                <div class="col-md-4">
                    <select id="sort" name="sort" class="form-control">
                        <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>Latest</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                        <option value="a-z" {{ request('sort') == 'a-z' ? 'selected' : '' }}>A-Z</option>
                        <option value="z-a" {{ request('sort') == 'z-a' ? 'selected' : '' }}>Z-A</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Apply Filters') }}
                    </button>
                </div>
            </div>
        </form>
    </div>

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
                        <p class="author">By <i>{{ $item->author }}</i></p>
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
                            <span class="page-link">&laquo; Previous Page</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a href="{{ $news->previousPageUrl() }}" class="page-link" rel="prev">&laquo; Previous Page</a>
                        </li>
                    @endif

                    {{-- Next Page Link --}}
                    @if ($news->hasMorePages())
                        <li class="page-item">
                            <a href="{{ $news->nextPageUrl() }}" class="page-link" rel="next">Next Page &raquo;</a>
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
@endsection
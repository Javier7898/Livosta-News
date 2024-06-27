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
                        <span class="page-link">&laquo; Previous Page</span>
                    </li>
                @else
                    <li class="page-item">
                        <a href="{{ $news->appends(request()->except('page'))->previousPageUrl() }}" class="page-link" rel="prev">&laquo; Previous</a>
                    </li>
                @endif

                {{-- Next Page Link --}}
                @if ($news->hasMorePages())
                    <li class="page-item">
                        <a href="{{ $news->appends(request()->except('page'))->nextPageUrl() }}" class="page-link" rel="next">Next &raquo;</a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">Next &raquo;</span>
                    </li>
                @endif
            </ul>
        </nav>
    @endif
</div>

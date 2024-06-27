@foreach ($news as $item)
    <div class="news-article">
        <h2>{{ $item->title }}</h2>
        <p><small>{{ $item->author }}</small></p>
        @if ($item->category)
            <p><small>Category: {{ $item->category->name }}</small></p>
        @else
            <p><small>Category: No category assigned</small></p>
        @endif
        @if ($item->image)
            <a href="{{ asset('storage/images/' . $item->image) }}">
                <img class="post-image" src="{{ asset('storage/images/' . $item->image) }}" alt="{{ $item->title }}">
            </a>
        @endif
        <p>{{ $item->content }}</p>
    </div>
@endforeach

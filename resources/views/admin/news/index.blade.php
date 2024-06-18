@extends('layouts.app')

@section('content')
    <h1>Admin News</h1>
    <a href="/admin/news/create">Create News</a>
    @foreach ($news as $item)
        <div class="news-article">
            <h2>{{ $item->title }}</h2>
            <p>{{ $item->content }}</p>
            @if ($item->image)
                <a href="{{ asset('storage/images/' . $item->image) }}"><img
                        src="{{ asset('storage/images/' . $item->image) }}" alt="{{ $item->title }}"></a>
            @endif
            <p><small>{{ $item->author }}</small></p>
            <a href="/admin/news/{{ $item->id }}/edit">Edit</a>
            <form action="/admin/news/{{ $item->id }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit">Delete</button>
            </form>
        </div>
    @endforeach
@endsection

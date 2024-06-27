@extends('layouts.app')

@section('custom-css')
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container admin-container">
        <h1>Admin Panel</h1>
        <a href="/admin/news/create" class="admin-btn">Create News</a>
        <div class="admin-news-grid">
            @foreach ($news as $item)
                <div class="admin-news-card">
                    <div class="news-article">
                        <h2>{{ $item->title }}</h2>
                        <p>{{ $item->category->name }}</p> <!-- Display category name -->
                        @if ($item->image)
                            <a href="{{ asset('storage/images/' . $item->image) }}">
                                <img class="post-image" src="{{ asset('storage/images/' . $item->image) }}" alt="{{ $item->title }}">
                            </a>
                        @endif
                        <p><small>{{ $item->author }}</small></p>
                        <div class="button-container">
                            <a href="/admin/news/{{ $item->id }}/edit" class="admin-btn-edit">Edit</a>
                            <form action="/admin/news/{{ $item->id }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="admin-btn-delete">Delete</button>
                            </form>
                            <form action="{{ route('admin.news.highlight', $item->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="admin-btn-highlight">Highlight</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

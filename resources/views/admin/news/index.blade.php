@extends('layouts.app')

@section('custom-css')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container admin-container">
        <h1>Admin News</h1>
        <a href="/admin/news/create" class="admin-btn">Create News</a>
        <div class="admin-news-grid">
            @foreach ($news as $item)
                <div class="admin-news-card">
                    <img src="{{ asset('storage/images/' . $item->image) }}" alt="{{ $item->title }}">
                    <div class="admin-news-card-content">
                        <span class="category-label">{{ $item->category ? $item->category->name : 'No category assigned' }}</span>
                        <h3>{{ $item->title }}</h3>
                        <p>{{ \Illuminate\Support\Str::limit($item->content, 150, $end='...') }}</p>
                        <p class="author">By {{ $item->author }}</p>
                        <div class="button-container">
                            <a href="/admin/news/{{ $item->id }}/edit" class="admin-btn-edit">Edit</a>
                            <form action="/admin/news/{{ $item->id }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="admin-btn-delete">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

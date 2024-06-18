@extends('layouts.app')

@section('content')
    <h1>Edit News</h1>
    <form action="/admin/news/{{ $news->id }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="{{ $news->title }}"><br>
        <label for="image">Image</label>
        <input type="file" class="form-control-file" id="image" name="image">
        @if ($news->image)
            <img src="{{ asset('storage/images/' . $news->image) }}" alt="{{ $news->title }}"><br>
        @endif
        <label for="content">Content:</label>
        <textarea id="content" name="content">{{ $news->content }}</textarea><br>
        <label for="author">Author:</label>
        <input type="text" id="author" name="author" value="{{ $news->author }}"><br>
        <button type="submit">Update</button>
    </form>
@endsection

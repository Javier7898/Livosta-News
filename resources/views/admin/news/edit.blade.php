@extends('layouts.app')

@section('content')
    <h1>Edit News</h1>
    <form action="/admin/news/{{ $news->id }}" method="POST">
        @csrf
        @method('PUT')
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="{{ $news->title }}"><br>
        <label for="content">Content:</label>
        <textarea id="content" name="content">{{ $news->content }}</textarea><br>
        <label for="author">Author:</label>
        <input type="text" id="author" name="author" value="{{ $news->author }}"><br>
        <button type="submit">Update</button>
    </form>
@endsection
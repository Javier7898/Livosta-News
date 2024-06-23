@extends('layouts.app')

@section('content')
    <h1>Create News</h1>
    <form action="/admin/news" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="title">Title:</label>
        <input type="text" id="title" name="title"><br>
        <label for="image">Image</label>
        <input type="file" class="form-control-file" id="image" name="image">
        <label for="content">Content:</label>
        <textarea id="content" name="content"></textarea><br>
        <label for="author">Author:</label>
        <input type="text" id="author" name="author"><br>
        <button type="submit">Submit</button>
    </form>
@endsection

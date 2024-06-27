@extends('layouts.app')

@section('custom-css')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="edit-news-form">
        <h1>Edit News</h1>
        <form action="/admin/news/{{ $news->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="{{ $news->title }}"><br>
            
            <label for="author">Author:</label>
            <input type="text" id="author" name="author" value="{{ $news->author }}"><br>
            
            <label for="category_id">Category:</label>
            <select id="category_id" name="category_id">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @if($news->category_id == $category->id) selected @endif>{{ $category->name }}</option>
                @endforeach
            </select><br>
            
            @if ($news->image)
                <img class="post-image" src="{{ asset('storage/images/' . $news->image) }}" alt="{{ $news->title }}"><br>
            @endif

            <label for="image">Image</label>
            <input type="file" class="form-control-file" id="image" name="image"><br>
            
            <label for="content">Content:</label>
            <textarea id="content" name="content">{{ $news->content }}</textarea><br>
            
            <button type="submit">Update</button>
        </form>
    </div>
@endsection
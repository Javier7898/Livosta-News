@extends('layouts.app')

@section('custom-css')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/create-edit.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <h1 class="create-form">Create News</h1>
    <form action="/admin/news" method="POST" enctype="multipart/form-data" class="create-form">
        @csrf
        <label for="title">Title:</label>a
        <input type="text" id="title" name="title">
        
        <label for="image">Image:</label>
        <input type="file" class="form-control-file" id="image" name="image">
        
        <label for="content">Content:</label>
        <textarea id="content" name="content"></textarea>
        
        <label for="author">Author:</label>
        <input type="text" id="author" name="author">
        
        <label for="category_id">Category:</label>
        <select id="category_id" name="category_id">
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
        
        <button type="submit">Submit</button>
    </form>
</div>
@endsection

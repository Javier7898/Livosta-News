@extends('layouts.app')

@section('content')
    <h1>{{ $news->title }}</h1>
    <p>{{ $news->content }}</p>
    @if ($news->image)
        <a href="{{ asset('storage/images/' . $news->image) }}"><img src="{{ asset('storage/images/' . $news->image) }}"
                alt="{{ $news->title }}"></a>
    @endif
    <p><strong>Author:</strong> {{ $news->author }}</p>
    <a href="/">Back</a>
@endsection

@extends('layouts.app')

@section('content')
    <h1>{{ $news->title }}</h1>
    <p>{{ $news->content }}</p>
    @if ($news->image)
        <a href="{{ asset('storage/images/' . $item->image) }}"><img src="{{ asset('storage/images/' . $item->image) }}"
                alt="{{ $item->title }}"></a>
    @endif
    <p><strong>Author:</strong></p>
    <a href="/">Back</a>
@endsection

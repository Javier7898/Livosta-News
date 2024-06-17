@extends('layouts.app')

@section('content')
    <h1>Berita Livosta</h1>
    @foreach ($news as $item)
        <div>
            <h2><a href="/news/{{ $item->id }}">{{ $item->title }}</a></h2>
            <p>{{ $item->content }}</p>
            <p><small>{{ $item->author }}</small></p>
        </div>
    @endforeach
@endsection

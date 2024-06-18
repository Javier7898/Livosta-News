@extends('layouts.app')

@section('content')
    <h1>Berita Livosta</h1>
    @foreach ($news as $item)
        <div class="news-article">
            <h2><a href="/news/{{ $item->id }}">{{ $item->title }}</a></h2>
            <p><Strong> Content : </Strong><br> {{ $item->content }}</p>
            @if ($item->image)
                <a href="{{ asset('storage/images/' . $item->image) }}"><img
                        src="{{ asset('storage/images/' . $item->image) }}" alt="{{ $item->title }}"></a>
            @endif
            <p><strong>Author : </strong><br>{{ $item->author }}</p>
        </div>
    @endforeach
    </div>
@endsection

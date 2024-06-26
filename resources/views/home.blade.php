@extends('layouts.app')

@section('custom-css')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <h1>Latest News</h1>

        <div>
            <label for="categoryFilter">Pilih Kategori:</label>
            <select id="categoryFilter">
                <option value="all">Semua Kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div id="newsList">
            @include('partials.news_list')
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#categoryFilter').change(function() {
                var category = $(this).val();

                $.ajax({
                    url: '{{ route("news.filter") }}',
                    type: 'GET',
                    data: { category: category },
                    success: function(response) {
                        $('#newsList').html(response);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection

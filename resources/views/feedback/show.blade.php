@extends('layouts.app')

@section('content')
    <div class="container feedback">
        <div class="card">
            <div class="card-header">
                Feedback ID: {{ $feedback->id }}
            </div>
            <div class="card-body">
                <h5 class="card-title">Username: {{ $feedback->username }}</h5>
                <p class="card-text">Title: {{ $feedback->title }}</p>
                @if ($feedback->image)
                    <img src="{{ asset('storage/images/'. $feedback->image) }}" alt="Feedback Image" class="img-fluid mt-2">
                @endif
                <p class="card-text">Content: {{ $feedback->content }}</p>
                <p class="card-text">Status: {{ ucfirst($feedback->status) }}</p>
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('feedback.index') }}" class="btn btn-info">Back to Feedback List</a>
        </div>
    </div>
@endsection

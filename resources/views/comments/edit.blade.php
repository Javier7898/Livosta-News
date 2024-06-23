@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit Comment') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('comments.update', $comment) }}">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="content">Comment</label>
                                <textarea name="content" id="content" class="form-control" rows="3" required>{{ $comment->content }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary mt-2">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

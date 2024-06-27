@extends('layouts.app')

@section('content')
    <div class="container feedback">
        <h1>Feedback List</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <a href="{{ route('feedback.create') }}" class="btn btn-primary mb-3">Create New Feedback</a>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($feedbacks as $feedback)
                            <tr>
                                <td>{{ $feedback->id }}</td>
                                <td>{{ $feedback->username }}</td>
                                <td>{{ $feedback->title }}</td>
                                <td>{{ ucfirst($feedback->status) }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('feedback.show', $feedback->id) }}"
                                            class="btn btn-info">View</a>
                                        @if (Auth::check() && Auth::user()->id == $feedback->user_id)
                                            <a href="{{ route('feedback.edit', $feedback->id) }}"
                                                class="btn btn-primary">Edit</a>
                                            <form action="{{ route('feedback.destroy', $feedback->id) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger"
                                                    onclick="return confirm('Are you sure you want to delete this feedback?')">Delete</button>
                                            </form>
                                        @endif
                                        @if (Auth::user()->isAdmin() && $feedback->status == 'pending')
                                            <form action="{{ route('admin.approveFeedback', $feedback->id) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-success">Approve</button>
                                            </form>
                                            <form action="{{ route('admin.rejectFeedback', $feedback->id) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-danger">Reject</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News App</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    @yield('custom-css')
</head>



<body>
    <nav class="navbar navbar-expand-md navbar-light bg-light">
        <a class="navbar-brand" href="/">
            <i class="fas fa-volleyball-ball"></i>
            Livosta
        </a>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/">Home</a>
                </li>
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('favorites') }}">Favorites</a>
                    </li>
                    @if (Auth::check() && Auth::user()->is_admin)
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/categories">Categories Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/news">News Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('feedback.index') }}">Feedback (Admin)</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('feedback.index') }}">Feedback</a>
                        </li>
                    @endif

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                    </li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @endauth
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="/register">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/login">Login</a>
                    </li>
                @endguest
            </ul>
        </div>
    </nav>
    <div class="container">
        @yield('content')
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
    @section('scripts')
        <script>
            $(document).ready(function() {
                $('#favorite-button').on('click', function(e) {
                    e.preventDefault();
                    var button = $(this);
                    var newsId = button.data('id');

                    // Disable the button to prevent multiple requests
                    button.prop('disabled', true);

                    $.ajax({
                        url: '{{ route('news.favorite', ['id' => '__news_id__']) }}'.replace(
                            '__news_id__', newsId),
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            // Optionally change the button text or style
                            button.text('Added to Favorites');
                            button.css('background-color', '#27ae60'); // Change color to green
                        },
                        error: function(xhr) {
                            // Handle error
                            alert('Failed to add to favorites. Please try again.');
                            button.prop('disabled', false); // Enable button if there's an error
                        }
                    });
                });
            });
        </script>
    @endsection
</body>

</html>

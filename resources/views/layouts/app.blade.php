<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Livosta News</title>
    <link rel="stylesheet" href="/css/app.css">
</head>

<body>
    <nav>
        <a href="/">Home</a>
        <a href="/register">Register</a>
        <a href="/admin/news">Login</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        <a class="nav-link" href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            {{ __('Logout') }}
        </a>
    </nav>
    <div class="container">
        @yield('content')
    </div>
</body>

</html>

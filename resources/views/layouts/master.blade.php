<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset("css/style.css")}}">
    <link rel="stylesheet" href="{{asset("css/search.css")}}">
    @yield('links')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="{{asset("js/app.js")}}"></script>
</head>
<body>
    <div class="nav-bar">
        <div class="nav-logo">
            <a href="{{route('index')}}"><img src="{{asset("assets/zelus_logo_white.png")}}" alt="controller"/></a>
        </div>

        <div class="nav-search">
            <form class="search_form" action="{{route('search')}}" method="GET">
                <input class="search_input" type="text" name="search" placeholder="Search">
                <button class="search_button" type="submit"><i class="fa-solid fa-search"></i></button>
            </form>
        </div>

        <nav class="nav-menu">
            <ul>
                <li class="nav-menu-item"><a href="{{route('index')}}">Home</a></li>
                <li class="nav-menu-item"><a href="#games">Games</a></li>
                <li class="nav-menu-item"><a href="#posts">Posts</a></li>
                @if (Route::has('login'))
                    @auth
                        <li class="nav-menu-item user"><a href="{{ route('profile.show',['profile' => Auth::user()->id]) }}"><i class="fa-solid fa-user"></i> {{ Auth::user()->username }}</a></li>
                        <li class="nav-menu-item logout"><a href="{{ route('logout') }}"><i class="fa-solid fa-power-off"></i></a></li>
                    @else
                        <li class="nav-menu-item login"><a href="{{ route('login') }}">Login</a></li>
                    @endauth
                @endif
            </ul>
        </nav>
    </div>
    @if (session('message'))
    <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @yield('content')
    <script src="https://cdn.tailwindcss.com"></script>
</body>
</html>

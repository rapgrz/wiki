<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ 'Wiki' }} {{exec('git describe --tags --abbrev=0')}}</title>
    <!-- Latest compiled and minified CSS -->

   <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('css')
</head>
<body>

        <nav class="navbar navbar-expand-lg navbar-light bg-light" >

            <a class="navbar-brand"  href="{{ url('/login') }}">

                Wiki
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

              <!-- Right Side Of Navbar -->
                <ul class="navbar-nav mr-auto justify-content-end">
                    <!-- Authentication Links -->
                    @guest
                    <li class="nav-item my-2 flex-row-reverse">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item my-2 flex-row-reverse">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                    @else
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Wiki <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{route('posts')}}">Posts</a>
                                @if(Auth::user()->access_level >= 3)
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{route('create_post')}}">Create post</a>
                                @endif
                                @if(Auth::user()->access_level >= 3)
                                <a class="dropdown-item" href="{{route('categories')}}">Categories</a>
                                @endif
                                @if(Auth::user()->access_level == 10)
                                <a class="dropdown-item" href="{{route('users')}}">Users</a>
                                @endif
                            </div>
                    </li>

                     <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            @if(Auth::user()->access_level == 10)
                            <a class="dropdown-item" href="{{route('dashboard')}}">Dashboard</a>
                            @endif
                            <a class="dropdown-item" href="{{route('profile', ['user_id' => Auth::user()->id])}}">Profile</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{route('logout')}}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                            </div>
                    </li>
                        @endguest
                    </ul>
            </nav>


    <div class="container">
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')

</body>
</html>

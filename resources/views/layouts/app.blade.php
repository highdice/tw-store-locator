<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Tom's World Store Locator</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link href="{{ elixir('css/all.css') }}" rel="stylesheet">

</head>
<body id="app-layout" class="{{ (Auth::guest()) ? 'guest-bg' : '' }}">
    @if (!Auth::guest())
    <nav class="navbar navbar-default">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/dashboard') }}">
                    Tom's World
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                @if (!Auth::guest())
                <ul class="nav navbar-nav">
                    <li class="{{ (Request::is('dashboard') || Request::is('/')) ? 'active' : '' }}"><a href="{{ url('/dashboard') }}"><i class="fa fa-btn fa-dashboard"></i>Dashboard</a></li>
                    <li class="{{ (Request::is('stores/locator')) ? 'active' : '' }}"><a href="{{ url('/stores/locator') }}"><i class="fa fa-btn fa-map-marker"></i>Locator</a></li>
                    <li class="{{ (Request::is('stores') || Request::is('stores/add') || Request::is('stores/*/edit')) ? 'active' : '' }}"><a href="{{ url('/stores') }}"><i class="fa fa-btn fa-building"></i>Stores</a></li>
                    <li class="{{ (Request::is('users') || Request::is('users/*')) ? 'active' : '' }}"><a href="{{ url('/users') }}"><i class="fa fa-btn fa-user"></i>Users</a></li>
                </ul>
                @endif

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                Welcome {{ ucwords(Auth::user()->name) }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/user/edit') }}"><i class="fa fa-btn fa-user"></i>Profile</a></li>
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
    </nav>
    @endif

    @yield('content')
    
    <div id="loader">
        <div class="circles-loader"></div>
    </div>

    <!-- JavaScripts -->
    <script src="{{ elixir('js/all.js') }}"></script>
    @yield('scripts')

</body>
</html>

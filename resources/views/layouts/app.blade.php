<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
    <link href="//gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-inverse bg-primary navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="{{ asset('img/run-a-derby-logo.png') }}" alt="{{ config('app.name', 'Laravel') }}" />
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        @if (!Auth::guest())
                            @can('Manage Contestants')
                            <li><a href="{{ route('contestants.index') }}"><i class="fa fa-btn fa-address-book"></i> Contestants</a></li>
                            @endcan
                            @can('Manage Heats')
                            <li><a href="{{ route('heats.index') }}"><i class="fa fa-btn fa-thermometer-quarter"></i> Heats</a></li>
                            @endcan
                            @can('Manage Runs')
                            <li><a href="{{ route('runs.index') }}"><i class="fa fa-btn fa-car"></i> Runs</a></li>
                            @endcan
                         @endif
                        <li><a href="{{ route('leader-board') }}"><i class="fa fa-btn fa-trophy"></i> Leader Board</a></li>
                        @role('Admin') {{-- Laravel-permission blade helper --}}
                        <li><a href="{{ route('leader-board-by-group') }}"><i class="fa fa-btn fa-trophy"></i> Leader Board By Group</a></li>
                        @endrole
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        @role('Admin') {{-- Laravel-permission blade helper --}}
                            @can('Change Configuration')
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    Configuration <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('groups.index') }}"><i class="fa fa-btn fa-object-group"></i> Groups</a>
                                        <a href="{{ route('dens.index') }}"><i class="fa fa-btn fa-home"></i> Dens</a>
                                        <a href="{{ route('scores-for-positions.index') }}"><i class="fa fa-btn fa-sliders"></i> Scores For Position</a>
                                    </li>
                                </ul>
                            </li>
                            @endcan
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    Administration <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('users.index') }}"><i class="fa fa-btn fa-users"></i> Users</a>
                                        <a href="{{ route('roles.index') }}"><i class="fa fa-btn fa-key"></i> Roles</a>
                                        <a href="{{ route('permissions.index') }}"><i class="fa fa-btn fa-key"></i> Permissions</a>
                                    </li>
                                </ul>
                            </li>
                        @endrole
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}"><i class="fa fa-btn fa-sign-in"></i> Login</a></li>
                            <li><a href="{{ route('register') }}"><i class="fa fa-btn fa-plus-circle"></i> Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    <img src="{{ gravatar( Auth::user()->email, 25 ) }}"> {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            <i class="fa fa-btn fa-sign-out"></i> Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>


        @if(Session::has('flash_message'))
            <div class="container-fluid">
                <div class="alert alert-success"><em> {!! session('flash_message') !!}</em>
                </div>
            </div>
        @endif
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    @include ('errors.list') {{-- Including error file --}}
                </div>
            </div>

            <div class="row">
                @yield('content')
            </div>
        </div>

    </div>

    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <small>Copyright &copy; 2017 Run a Derby - All Rights Reserved</small>
                </div>
                <div class="col-md-6 text-right">
                    <small>Website Design By: <a href="https://www.fasttracksites.com">Fast Track Sites, LLC</a></small>
                </div>
            </div>
        </div>
    </footer>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="//use.fontawesome.com/9712be8772.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
    <script src="//gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
</body>
</html>

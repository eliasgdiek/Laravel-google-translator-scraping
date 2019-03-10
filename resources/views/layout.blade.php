<!doctype html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Google Translation Scraping</title>
<link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
<link href="https://fonts.googleapis.com/css?family=Bree+Serif" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap-4.0.0-beta.3-dist/css/bootstrap.min.css') }}"/>

<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}"/>
@yield('styles')
</head>
<body>
<header>
    <div class="wrapper clearfix" id="logo">
        <div class="logo text-left"><a class="text-white" href="{{ url('/') }}"><h2>Google Translation Scraping</h2></a></div>
    </div>
    <ul class="top-right">
        <!-- Authentication Links -->
        @guest
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
            @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
            @endif
        @else
            <li class="nav-item dropdown">
                <a class="" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        @endguest
    </ul>
</header>
@yield('content')
<footer>
    <p>&copy; reservele</p>
</footer>
<script src="https://code.jquery.com/jquery.js"></script> 
<script src="{{ asset('assets/bootstrap-4.0.0-beta.3-dist/js/bootstrap.min.js') }}"></script>
@yield('scripts')
</body>
</html>
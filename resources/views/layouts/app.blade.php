<!doctype html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel='stylesheet' href='https://unpkg.com/@fortawesome/fontawesome-svg-core@1.2.17/styles.css' integrity='sha384-bM49M0p1PhqzW3LfkRUPZncLHInFknBRbB7S0jPGePYM+u7mLTBbwL0Pj/dQ7WqR' crossorigin='anonymous'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome-animation/0.0.10/font-awesome-animation.css" type="text/css" media="all" />
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('css')

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    @stack('js')

</head>

<body>
    <div id="app">

        <style>
            .nav-link i{
                color: grey;
                font-size: 30px;
            }
        </style>

        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        @guest
                            <li class="nav-item">
                                {{-- LIB Logoでindex画面のリンクになります。 --}}
                                <a class="navbar-brand" href="{{ url('/welcome') }}">
                                    welcome
                                </a>
                            </li>
                        @endguest
                    </ul>
                    @auth
                        <ul class="navbar-nav mx-auto align-items-center justify-content-around flex-grow-1">
                            <li class="nav-item dropdown">
                                {{-- ログアウトのリンク --}}
                                <a id="navbarDropdown" class="nav-link" href="{{ route('logout') }}" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="fa fa-sign-out fa-2x" aria-hidden="true"></i>
                                </a>
                            </li>

                            <li class="nav-item">
                                {{-- index画面のリンク --}}
                                <a class="navbar-brand" href="{{ url('/users') }}">
                                    <i class="fa fa-heart"></i>
                                </a>
                            </li>

                            {{-- マッチしたusers一覧画面 --}}
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('users.matches') }}">
                                    <i class="fa fa-comments fa-2x" aria-hidden="true"></i>
                                </a>
                            </li>

                            {{-- プロフィール編集画面 --}}
                            <li class="nav-item">
                                {{-- <a class="nav-link" href="{{ route('users.profile') }}"> --}}
                                    <i class="fa fa-cog"></i>
                                </a>
                            </li>
                        </ul>
                    @endauth

                    <ul class="navbar-nav ml-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>

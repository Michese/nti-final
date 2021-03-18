<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                    @auth
                        @if(Gate::allows(env('IS_ADMIN'), Auth::user()) && Route::has('admin.users'))
                            <li class="nav-item @if(Route::is('admin.users')) active @endif">
                                <a class="nav-link" href="{{ route('admin.users') }}">
                                    Пользователи
                                </a>
                            </li>
                        @endif

                        @if(Gate::allows(env('IS_DIRECTOR'), Auth::user()) && Route::has('director.users'))
                            <li class="nav-item @if(Route::is('director.users')) active @endif">
                                <a class="nav-link" href="{{ route('director.users') }}">
                                    Пользователи
                                </a>
                            </li>
                        @endif

                            @if(Gate::allows(env('IS_DISPATCHER'), Auth::user()) && Route::has('dispatcher.map'))
                                <li class="nav-item @if(Route::is('dispatcher.map')) active @endif">
                                    <a class="nav-link" href="{{ route('dispatcher.map') }}">
                                        Карта
                                    </a>
                                </li>
                            @endif

                            @if(Gate::allows(env('IS_DRIVER'), Auth::user()) && Route::has('driver.orderStatus'))
                                <li class="nav-item @if(Route::is('driver.orderStatus')) active @endif">
                                    <a class="nav-link" href="{{ route('driver.orderStatus') }}">
                                        Статус заказов
                                    </a>
                                </li>
                            @endif

                            @if(Gate::allows(env('IS_CLIENT'), Auth::user()) && Route::has('client.order'))
                                <li class="nav-item @if(Route::is('client.order')) active @endif">
                                    <a class="nav-link" href="{{ route('client.order') }}">
                                        Заказать
                                    </a>
                                </li>
                            @endif

                            @if(Gate::allows(env('IS_CLIENT'), Auth::user()) && Route::has('client.card'))
                                <li class="nav-item @if(Route::is('client.card')) active @endif">
                                    <a class="nav-link" href="{{ route('client.card') }}">
                                        Корзина
                                    </a>
                                </li>
                            @endif

                            @if(Gate::allows(env('IS_CLIENT'), Auth::user()) && Route::has('client.orderStatus'))
                                <li class="nav-item @if(Route::is('client.orderStatus')) active @endif">
                                    <a class="nav-link" href="{{ route('client.orderStatus') }}">
                                        Статус заказов
                                    </a>
                                </li>
                            @endif

                            @if(Gate::allows(env('IS_WAREHOUSEMAN'), Auth::user()) && Route::has('warehouseman.map'))
                                <li class="nav-item @if(Route::is('warehouseman.map')) active @endif">
                                    <a class="nav-link" href="{{ route('warehouseman.map') }}">
                                        Карта
                                    </a>
                                </li>
                            @endif


                    @endauth
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('auth.login.index'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('auth.login.index') }}">Войти</a>
                            </li>
                        @endif

                        @if (Route::has('auth.register.index'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('auth.register.index') }}">Зарегистрироваться</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                @if(Gate::denies(env('IS_ADMIN'), Auth::user()) && Route::has('profile.index'))
                                    <a class="dropdown-item" href="{{ route('profile.index') }}">Личный кабинет</a>
                                @endif

                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    Выйти
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>
    <footer class="footer">

    </footer>
</div>

</body>
</html>

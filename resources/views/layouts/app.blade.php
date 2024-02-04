<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('Gerenciador de dispensa') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/script.js') }} " defer></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>

    <!-- Fonts -->
    <!-- CSS only -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/select2-bootstrap-5-theme.css') }}" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.png') }}?v={{ date('YmdHis') }}">

</head>

<body style="background-color: #edf0f5;">
    <div id="app">

        @guest
            @if (Route::has('login'))
            @endif

            @if (Route::has('register'))
            @endif
        @else
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container">
                    <a class="navbar-brand" href="{{ route('home') }}">
                        @include('components.application-logo-nav')
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav me-auto">

                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ms-auto">
                            <!-- Authentication Links -->
                            <?php $perfil = auth()->user()->perfil; ?>
                            @if (auth()->check() and $perfil === 'Administrador' or auth()->check() and $perfil === 'Editor')
                                <li class="nav-item me-5">
                                    <a class="nav-link"
                                        href="{{ action('App\Http\Controllers\DispensaController@index') }}"><i
                                            class="bi bi-credit-card me-1"></i>Despesa</a>
                                </li>
                            @endif

                            <li class="nav-item dropdown me-5">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false" v-pre><i
                                        class="bi bi-activity me-1"></i>Relatórios</a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <h6 class="dropdown-header">Relátórios de despesa</h6>
                                    </li>
                                    <li><a class="dropdown-item"
                                            href="{{ action('App\Http\Controllers\RelatorioController@porSubclasse') }}"><i
                                                class="bi bi-collection"></i> Relação por subclasse</a></li>
                                    <li><a class="dropdown-item"
                                            href="{{ action('App\Http\Controllers\RelatorioController@porSubclasseResumido') }}"><i
                                                class="bi bi-view-stacked"></i> Relação por subclasse resumido</a></li>
                                    <li><a class="dropdown-item"
                                            href="{{ action('App\Http\Controllers\RelatorioController@totalDispensa') }}"><i
                                                class="bi bi-list"></i> Relação total de despesas</a></li>
                                </ul>


                            </li>

                            @if (auth()->check() and $perfil === 'Administrador')
                                <li class="nav-item me-5">
                                    <a class="nav-link"
                                        href="{{ action('App\Http\Controllers\UsersController@listarTudo') }}"><i
                                            class="bi bi-people me-1"></i>Usuários</a>
                                </li>
                            @endif
                            
                            <li class="nav-item dropdown me-5">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false" v-pre><i
                                        class="bi bi-headset me-1"></i>Suporte</a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <h6 class="dropdown-header">Canais de suporte</h6>
                                    </li>
                                    <li><a class="dropdown-item"
                                        href="https://api.whatsapp.com/send?phone=45999157595&text=Olá,%20gostaria%20de%20ter%20mais%20detalhes%20sobre%20o%20suporte%20jurídico." target="_blank"><i
                                            class="bi bi-whatsapp me-1"></i>Suporte
                                        jurídico</a></li>

                                        <li><a class="dropdown-item"
                                        href="https://api.whatsapp.com/send?phone=45999406202&text=Olá,%20gostaria%20de%20auxílio%20técnico." target="_blank"><i
                                            class="bi bi-whatsapp me-1" ></i>Suporte
                                        técnico</a></li>
                                </ul>
                            </li>

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="bi bi-person-circle me-1"></i>
                                    {{ Auth::user()->name }}

                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('users.minhaConta') }}">
                                        <i class="bi bi-person me-1"></i>
                                        {{ __('Minha conta') }}

                                    </a>
                                    @if (auth()->check() and auth()->user()->admin)
                                        <a class="dropdown-item" href="{{ route('configs.carregarConfig') }}">
                                            <i class="bi bi-gear me-1"></i>
                                            {{ __('Configurações') }}

                                        </a>
                                        <a class="dropdown-item" href="{{ route('cnae.create') }}">
                                            <i class="bi bi-arrow-clockwise me-1"></i>
                                            {{ __('Atualizar base CNAE') }}

                                        </a>
                                    @endif
                                    @if (auth()->check() and $perfil === 'Administrador')
                                        <a class="dropdown-item" href="{{ route('logs.alteracoes') }}">
                                            <i class="bi bi-card-list me-1"></i>
                                            {{ __('Log de alterações') }}

                                        </a>
                                    @endif

                                    <hr>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="bi bi-door-open me-1"></i>
                                        {{ __('Sair') }}

                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        @endguest
        <main class="py-4">
            @yield('content')
        </main>
        @include('layouts.footer')
    </div>
</body>

</html>

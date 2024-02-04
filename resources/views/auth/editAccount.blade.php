@extends('layouts.app')

@section('content')
    <h3 class="ms-5 me-5">Minha conta</h3>
    <nav class="ms-5 me-5" style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item ms-1 me-1"><a href="{{ route('home') }}"><i class="bi bi-house me-1"></i>Página
                    inicial</a></li><i class="bi bi-chevron-right"></i>
            <li class="breadcrumb-item ms-1 me-1 active" aria-current="page"><a href="{{ route('users.listarTudo') }}"><i
                        class="bi bi-people me-1"></i>Minha Conta</a></li><i class="bi bi-chevron-right"></i>
            <li class="breadcrumb-item ms-1 me-1 active" aria-current="page"><i class="bi bi-pencil-square me-2"></i>Edição
            </li>
        </ol>
    </nav>
    <div class="card ms-5 me-5" style="border-radius:10px;">

        <div class="card-body">
            <form method="POST" action="{{ action('App\Http\Controllers\UsersController@updateConta', $user->id) }}">
                @csrf

                <div class="mb-2">
                    <label for="name" class="col-form-label">{{ __('Nome do usuário *') }}</label>

                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                        name="name" value="{{ $user->name }}" placeholder="Informe o nome do novo usuário" required
                        autocomplete="name" autofocus>

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>

                <div class="row ">

                    <div class="col mb-2">
                        <label for="matricula" class="col-form-label">{{ __('Número da matrícula *') }}</label>

                        <div class="md-6">
                            <input id="matricula" type="text"
                                class="form-control @error('matricula') is-invalid @enderror" name="matricula"
                                value="{{ $user->matricula }}" placeholder="Número da matrícula " required
                                autocomplete="matricula" autofocus>

                            @error('matricula')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>


                    <div class="col mb-2">
                        <label for="perfil" class="col-form-label">{{ __('Perfil de acesso *') }}</label>

                        <div class="cmd-6">
                            <select id="perfil" class="form-select @error('perfil') is-invalid @enderror" name="perfil"
                                required autocomplete="perfil" autofocus>
                                <option name="Administrador" {{ $user->perfil == 'Administrador' ? 'selected' : '' }}>
                                    Administrador</option>
                                <option name="Editor" {{ $user->perfil == 'Editor' ? 'selected' : '' }}>Editor</option>
                                <option name="Visualizador" {{ $user->perfil == 'Visualizador' ? 'selected' : '' }}>
                                    Visualizador</option>
                            </select>

                            @error('perfil')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col mb-3">
                        <label for="email" class="col-form-label">{{ __('Endereço de e-mail *') }}</label>

                        <div class="md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ $user->email }}" placeholder="E-mail para acesso ao sistema"
                                required autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                </div>
                <div class="row mt-3">
                    <div class="d-flex flex-row-reverse">
                        <button type="submit" class="btn btn-primary ms-3"><i class="bi bi-arrow-repeat"></i>
                            {{ __('Atualizar informações principais') }}
                        </button>

                    </div>
                </div>
            </form>
            <h5 class="mt-3">Alteração de senha</h5>
            <hr>
            <form action="{{ action('App\Http\Controllers\UsersController@updateSenha', $user->id) }}" method="post">
                @csrf
                <div class="row">

                    <div class="col">
                        <label for="current_password" class="col-form-label">Senha atual</label>
                        <div class="md-6">
                            <input id="current_password" type="password"
                                class="form-control @error('current_password') is-invalid @enderror" name="current_password"
                                placeholder="Senha atual" required autocomplete="new-password">
                            @error('current_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col">
                        <label for="password" class="col-form-label">Nova senha</label>
                        <div class="md-6">
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password"
                                placeholder="Nova senha" required autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col">
                        <label for="password-confirm" class="col-form-label">Confirmar nova senha</label>
                        <div class="md-6">
                            <input id="password-confirm" type="password" class="form-control"
                                name="password_confirmation" placeholder="Confirmar nova senha" required
                                autocomplete="new-password">

                        </div>

                    </div>
                </div>
                <div class="row mt-5 mb-3">
                    <div class="d-flex flex-row-reverse">

                        <button type="submit" class="btn btn-primary ms-3"><i class="bi bi-lock"></i>
                            {{ __('Alterar senha') }}
                        </button>

                    </div>
                </div>
            </form>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

        @if (session('update'))
            <script>
                swal("Sua conta foi atualizadas com sucesso!", {
                    icon: "success",
                    buttons: false
                });
            </script>
        @endif
    </div>
    </div>
@endsection

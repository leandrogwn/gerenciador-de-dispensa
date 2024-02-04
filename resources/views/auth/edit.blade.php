@extends('layouts.app')

@section('content')
    <h3 class="ms-5 me-5">Edição de usuário</h3>
    <nav class="ms-5 me-5" style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item ms-1 me-1"><a href="{{ route('home') }}"><i class="bi bi-house me-1"></i>Página
                    inicial</a></li><i class="bi bi-chevron-right"></i>
            <li class="breadcrumb-item ms-1 me-1 active" aria-current="page"><a href="{{ route('users.listarTudo') }}"><i
                        class="bi bi-people me-1"></i>Lista de usuários</a></li><i class="bi bi-chevron-right"></i>
            <li class="breadcrumb-item ms-1 me-1 active" aria-current="page"><i
                class="bi bi-pencil-square me-2"></i>Edição de usuário
            </li>
        </ol>
    </nav>
    <div class="card ms-5 me-5" style="border-radius:10px;">

        <div class="card-body">
            <form method="POST" action="{{ action('App\Http\Controllers\UsersController@updateUsuario', $user->id) }}">
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
                            {{ __('Atualizar usuário') }}
                        </button>
                        <a class="btn btn-outline-secondary" href="{{ route('users.listarTudo') }}"><i
                                class="bi bi-arrow-left"></i>
                            {{ __('Cancelar') }}
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

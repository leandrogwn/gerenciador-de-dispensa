@extends('layouts.app')

@section('content')
    <h3 class="ms-5 me-5">Novo orgão público</h3>
    <nav class="ms-5 me-5" style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item ms-1 me-1"><a href="{{ route('home') }}"><i class="bi bi-house me-1"></i>Página inicial</a></li><i
                class="bi bi-chevron-right"></i>
            <li class="breadcrumb-item ms-1 me-1 active" aria-current="page"><a href="{{ route('townhalls.listarTudo') }}"><i
                        class="bi bi-people me-1"></i>Lista de orgãos públicos</a></li><i class="bi bi-chevron-right"></i>
            <li class="breadcrumb-item ms-1 me-1 active" aria-current="page"><i class="bi bi-plus-lg me-2"></i>Novo orgão público
            </li>
        </ol>
    </nav>
    <div class="card ms-5 me-5" style="border-radius:10px;">

        <div class="card-body">
            <form method="POST" action="{{ action('App\Http\Controllers\TownhallsController@salvarPrefeitura') }}">
                @csrf

                <div class="mb-2">
                    <label for="cidade" class="col-form-label">{{ __('Nome do órgão público *') }}</label>

                    <input id="cidade" type="text" class="form-control @error('cidade') is-invalid @enderror"
                        name="cidade" value="{{ old('cidade') }}" placeholder="Informe o nome do orgão e cidade. Ex: Prefeitura de Curitiba ou Camára de vereadores de Curitiba" required
                        autocomplete="cidade" autofocus>

                    @error('cidade')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>

                <div class="row ">

                    <div class="col mb-2">
                        <label for="fone" class="col-form-label">{{ __('Telefone *') }}</label>

                        <div class="md-6">
                            <input id="fone" type="text"
                                class="form-control @error('fone') is-invalid @enderror" name="fone"
                                value="{{ old('fone') }}" placeholder="Telefone de contato " required
                                autocomplete="fone" autofocus onkeypress="mask(this, mphone);" onblur="mask(this, mphone);">

                            @error('fone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col mb-2">
                        <label for="responsavel" class="col-form-label">{{ __('Responsável *') }}</label>

                        <div class="md-6">
                            <input id="responsavel" type="text"
                                class="form-control @error('responsavel') is-invalid @enderror" name="responsavel"
                                value="{{ old('responsavel') }}" placeholder="Responsável pelo sistema" required
                                autocomplete="responsavel" autofocus>

                            @error('responsavel')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col mb-2">
                        <label for="matricula" class="col-form-label">{{ __('Matrícula *') }}</label>

                        <div class="md-6">
                            <input id="matricula" type="text"
                                class="form-control @error('matricula') is-invalid @enderror" name="matricula"
                                value="{{ old('matricula') }}" placeholder="Matrícula do responsável" required
                                autocomplete="matricula" autofocus>

                            @error('matricula')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    
                </div>

                <div class="row">
                    <div class="col mb-3">
                        <label for="email"
                            class="col-form-label">{{ __('Endereço de e-mail *') }}</label>

                        <div class="md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" placeholder="E-mail para acesso ao sistema"
                                required autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col mb-3">
                        <label for="password" class="col-form-label">{{ __('Senha *') }}</label>

                        <div class="md-6">
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password"
                                placeholder="Senha para acesso ao sistema" required autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col mb-3">
                        <label for="password-confirm"
                            class="col-form-label">{{ __('Confirmar senha *') }}</label>

                        <div class="md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                                placeholder="Digite a mesma senha novamente" required autocomplete="new-password">
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="d-flex flex-row-reverse">
                        <button type="submit" class="btn btn-primary ms-3"><i
                            class="bi bi-plus-lg me-2"></i>
                            {{ __('Cadastrar orgão público') }}
                        </button>
                        <a class="btn btn-outline-secondary" href="{{ route('townhalls.listarTudo') }}"><i class="bi bi-arrow-left"></i>
                            {{ __('Cancelar') }}
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

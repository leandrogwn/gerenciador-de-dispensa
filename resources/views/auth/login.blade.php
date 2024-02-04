@extends('layouts.app')

@section('content')
    <style>
        html,
        body {
            height: 100%;
        }

        body {
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
    
    <div class="container">

        @include('components.application-logo')

        <div class="card mt-3 shadow " style="width: 373px; border-radius:10px;">
            <div class="row ms-4 mt-4 fs-5 fw-bolder">Login</div>
            <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="row">

                        <div>
                            <label for="email" class="col-form-label">{{ __('Endereço de e-mail') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-1">

                        <div>
                            <label for="password" class="col-form-label text-md-end">{{ __('Senha') }}</label>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row my-2">
                        <div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Continuar conectado') }}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div>
                            <button type="submit" class="btn btn-primary" style="width: 340px">
                                {{ __('Logar') }}
                            </button>

                        </div>

                        @if (Route::has('password.request'))
                            <a class="btn btn-link mt-3" href="{{ route('password.request') }}">
                                {{ __('Esqueceu sua senha?') }}
                            </a>
                        @endif

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

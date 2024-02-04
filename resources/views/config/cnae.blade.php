@extends('layouts.app')

@section('content')
    <h3 class="ms-5 me-5">Atualizador base CNAE</h3>
    <nav class="ms-5 me-5" style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item ms-1 me-1"><a href="{{ route('home') }}"><i class="bi bi-house me-1"></i>Página
                    inicial</a></li><i class="bi bi-chevron-right"></i>
            <li class="breadcrumb-item ms-1 me-1 active" aria-current="page"><i class="bi bi-arrow-clockwise me-2"></i>Atualizador base CNAE
            </li>
        </ol>
    </nav>
    <div class="card ms-5 me-5" style="border-radius:10px;">

        <div class="card-body">
            <p > No momento o sistema esta com a versão {{$versao }} importada.</p><hr>
            <form method="POST" action="{{ action('App\Http\Controllers\CnaeController@update') }}">
                @csrf
                <label for="versao">Informe a versão da nova atualização</label>
                <input class="form-control" type="text" name="versao" id="versao" placeholder="Número disponibilizado no site do IBGE" required>

                <div class="row mt-3">
                    <div class="d-flex flex-row-reverse">
                        <button type="submit" class="btn btn-primary ms-3"><i class="bi bi-arrow-clockwise"></i>
                            {{ __('Atualizar') }}
                        </button>

                    </div>
                </div>
            </form>

        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

        @if (session('update'))
            <script>
                swal("Atualização realizada com sucesso!", {
                    icon: "success",
                    buttons: false
                });
            </script>
        @endif
    </div>
    </div>
@endsection

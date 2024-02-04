@extends('layouts.app')

@section('content')
    <h3 class="ms-5 me-5">Configurações</h3>
    <nav class="ms-5 me-5" style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item ms-1 me-1"><a href="{{ route('home') }}"><i class="bi bi-house me-1"></i>Página
                    inicial</a></li><i class="bi bi-chevron-right"></i>
            <li class="breadcrumb-item ms-1 me-1 active" aria-current="page"><i class="bi bi-gear me-2"></i>Configurações
            </li>
        </ol>
    </nav>
    <div class="card ms-5 me-5" style="border-radius:10px;">

        <div class="card-body">
            <form method="POST" action="{{ action('App\Http\Controllers\ConfigController@updateConfig') }}">
                @csrf



                <div class="row ">

                    <div class="col mb-2">
                        <label for="obras_eng_man_vei"
                            class="col-form-label">{{ __('Obras Serv. de Eng. e Man de Veí. *') }}</label>

                        <div class="md-6">
                            <input id="obras_eng_man_vei" type="text"
                                class="form-control @error('obras_eng_man_vei') is-invalid @enderror"
                                name="obras_eng_man_vei"
                                value="{{ 'R$ ' . number_format($config[0]->obras_eng_man_vei, 2, ',', '.') }}"
                                placeholder="Valor em reais " required autocomplete="obras_eng_man_vei">

                            @error('obras_eng_man_vei')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col mb-2">
                        <label for="aquis_servicos" class="col-form-label">{{ __('Aquis e Serviços *') }}</label>

                        <div class="md-6">
                            <input id="aquis_servicos" type="text"
                                class="form-control @error('aquis_servicos') is-invalid @enderror" name="aquis_servicos"
                                value="{{ 'R$ ' . number_format($config[0]->aquis_servicos, 2, ',', '.') }}"
                                placeholder="Valor em reais " required autocomplete="aquis_servicos">

                            @error('aquis_servicos')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col mb-2">
                        <label for="pag_rel_subs" class="col-form-label">{{ __('Qtd. por Subclasse *') }}</label>

                        <div class="md-6">
                            <input id="pag_rel_subs" type="number"
                                class="form-control @error('pag_rel_subs') is-invalid @enderror" name="pag_rel_subs"
                                value="{{ $config[0]->pag_rel_subs }}" placeholder="Qtd. itens por página " required
                                autocomplete="pag_rel_subs">

                            @error('pag_rel_subs')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col mb-2">
                        <label for="pag_rel_sub_res" class="col-form-label">{{ __('Qtd. por Sub. Resumido *') }}</label>

                        <div class="md-6">
                            <input id="pag_rel_sub_res" type="number"
                                class="form-control @error('pag_rel_sub_res') is-invalid @enderror" name="pag_rel_sub_res"
                                value="{{ $config[0]->pag_rel_sub_res }}" placeholder="Qtd. itens por página " required
                                autocomplete="pag_rel_sub_res">

                            @error('pag_rel_sub_res')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col mb-2">
                        <label for="pag_rel_total" class="col-form-label">{{ __('Qtd. Total de Dispe. *') }}</label>

                        <div class="md-6">
                            <input id="pag_rel_total" type="number"
                                class="form-control @error('pag_rel_total') is-invalid @enderror" name="pag_rel_total"
                                value="{{ $config[0]->pag_rel_total }}" placeholder="Qtd. itens por página " required
                                autocomplete="pag_rel_total">

                            @error('pag_rel_total')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                </div>


                <div class="row mt-3">
                    <div class="d-flex flex-row-reverse">
                        <button type="submit" class="btn btn-primary ms-3"><i class="bi bi-gear"></i>
                            {{ __('Atualizar Configurações') }}
                        </button>

                    </div>
                </div>
            </form>

        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

        @if (session('update'))
            <script>
                swal("Configurações atualizadas com sucesso!", {
                    icon: "success",
                    buttons: false
                });
            </script>
        @endif
    </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <h3 class="ms-5 me-5">Edição de despesa</h3>
    <nav class="ms-5 me-5" style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item ms-1 me-1"><a href="{{ route('home') }}"><i class="bi bi-house me-1"></i>Página
                    inicial</a></li><i class="bi bi-chevron-right"></i>
            <li class="breadcrumb-item ms-1 me-1 active" aria-current="page"><a href="{{ route('townhalls.listarTudo') }}"><i
                        class="bi bi-people me-1"></i>Lista de despesas</a></li><i class="bi bi-chevron-right"></i>
            <li class="breadcrumb-item ms-1 me-1 active" aria-current="page"><i class="bi bi-pencil-square me-2"></i>Edição
                de despesa
            </li>
        </ol>
    </nav>
    <div class="card ms-5 me-5" style="border-radius:10px;">

        <div class="card-body">
            <form method="POST" action="{{ action('App\Http\Controllers\DispensaController@update', $dispensa->id) }}">
                @csrf
                <div class="row">
                    <div class="col">
                        <label for="user-name">Nome do usuário</label>
                        <h3 id="user-name">{{ $user->name }}</h3>
                    </div>
                    <div class="col">
                        <label for="user-matricula">Matricula</label>
                        <h3 id="user-matricula">{{ $user->matricula }}</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-2">
                        <label for="modalidade" class="col-form-label">{{ __('Modalidade da despesa*') }}</label>

                        <select name="modalidade" style="width: 100%"
                            class="form-select @error('modalidade') is-invalid @enderror"
                            @error('modalidade') autofocus @enderror id="modalidade" required autocomplete="modalidade">
                            <option value="{{ old('modalidade', '') }}">{{ old('modalidade', 'Selecione a modalidade') }}
                            </option>
                            <option value="Concorrência" @if ($dispensa->modalidade == 'DisConcorrênciapensa') selected @endif>Concorrência
                            </option>
                            <option value="Dispensa" @if ($dispensa->modalidade == 'Dispensa') selected @endif>Dispensa</option>
                            <option value="Inexigibilidade" @if ($dispensa->modalidade == 'Inexigibilidade') selected @endif>Inexigibilidade</option>
                            <option value="Pregão" @if ($dispensa->modalidade == 'Pregão') selected @endif>Pregão</option>
                            <option value="Tomada de preço" @if ($dispensa->modalidade == 'Tomada de preço') selected @endif>Tomada de
                                preço</option>

                        </select>

                        @error('modalidade')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>
                    <div class="col mb-2">
                        <label for="discriminacao" class="col-form-label">{{ __('Discriminação do item *') }}</label>

                        <input id="discriminacao" type="text"
                            class="form-control @error('discriminacao') is-invalid @enderror" name="discriminacao"
                            value="{{ $dispensa->discriminacao }}" placeholder="Informe a discriminação do item" required
                            autocomplete="discriminacao" autofocus>

                        @error('discriminacao')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>
                </div>

                <div class="row">
                    <div class="col mb-2">
                        <label for="sub_classe_cnae" class="col-form-label">{{ __('Selecione a subclasse *') }}</label>

                        <input type="text" name="sub_classe_cnae" id="sub_classe_cnae" style="width: inherit"
                            oninput="encontrarCnae()" onclick="limpar()"
                            class="form-control @error('sub_classe_cnae') is-invalid @enderror"
                            @error('sub_classe_cnae') autofocus @enderror value="{{ $dispensa->sub_classe_cnae }} · {{ $dispensa->atividade }}"
                            placeholder="Digite no minímo 3 caracteres para iniciar a busca" required
                            autocomplete="sub_classe_cnae" onblur="dropDownCnae(1)">

                        <div id="dropDownCnae" class="dropDownCnae" style="position: absolute;">
                            <div id="listDropDownCnae" class="listDropDownCnae">

                            </div>

                        </div>
                        @error('sub_classe_cnae')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>
                </div>

                <div class="row ">

                    <div class="col mb-2">
                        <label for="grupo_despesa" class="col-form-label"
                            title="Classificação da despesa">{{ __('Classificação *') }}</label>

                        <select name="grupo_despesa" style="width: 100%"
                            class="form-select @error('grupo_despesa') is-invalid @enderror"
                            @error('grupo_despesa') autofocus @enderror id="grupo_despesa" required
                            autocomplete="grupo_despesa">
                            <option value="{{ old('grupo_despesa', '') }}">
                                {{ old('grupo_despesa', 'Selecione a classificação') }}</option>
                            <option value="Compras e Serviços" @if ($dispensa->grupo_despesa == 'Compras e Serviços') selected @endif>Compras e
                                Serviços</option>
                            <option value="Obras, serv. Engenharia e veículos"
                                @if ($dispensa->grupo_despesa == 'Obras, serv. Engenharia e veículos') selected @endif>Obras, serv. eng. e veí.</option>

                        </select>

                        @error('grupo_despesa')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>

                    <div class="col mb-2">
                        <label for="valor" class="col-form-label" title="Valor da despesa">{{ __('Valor *') }}</label>

                        <div class="md-6">
                            <input id="valor" type="text"
                                class="form-control @error('valor') is-invalid @enderror" name="valor"
                                value="{{ 'R$ ' . number_format($dispensa->valor, 2, ',', '.') }}"
                                placeholder="Informe o valor da despesa " required autocomplete="valor"
                                style="text-align: right">

                            @error('valor')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col mb-2">
                        <label for="numero_dispensa" class="col-form-label"
                            title="Número da despesa">{{ __('Número *') }}</label>

                        <div class="md-6">
                            <input id="numero_dispensa" type="text"
                                class="form-control @error('numero_dispensa') is-invalid @enderror"
                                name="numero_dispensa" value="{{ $dispensa->numero_dispensa }}"
                                placeholder="Informe o número da despesa" required autocomplete="numero_dispensa">

                            @error('numero_dispensa')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col mb-2">
                        <label for="numero_processo_licitatorio" class="col-form-label"
                            title="Número do processo licitatório">{{ __('Processo *') }}</label>

                        <div class="md-6">
                            <input id="numero_processo_licitatorio" type="text"
                                class="form-control @error('numero_processo_licitatorio') is-invalid @enderror"
                                name="numero_processo_licitatorio" value="{{ $dispensa->numero_processo_licitatorio }}"
                                placeholder="Informe o número do processo" required
                                autocomplete="numero_processo_licitatorio">

                            @error('numero_processo_licitatorio')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                </div>
                <div class="row mt-3">
                    <div class="d-flex flex-row-reverse">
                        <button type="submit" class="btn btn-primary ms-3"><i
                                class="bi bi-plus-lg me-2"></i>
                            {{ __('Atualizar despesa') }}
                        </button>
                        <a class="btn btn-outline-secondary" href="{{ route('dispensa.index') }}"><i
                                class="bi bi-arrow-left"></i>
                            {{ __('Cancelar') }}
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function limpar() {
            document.getElementById('sub_classe_cnae').value = "";
        }

        function select(a) {
            var item = document.getElementById(a).innerHTML;
            document.getElementById('sub_classe_cnae').value = item;
        }

        function dropDownCnae(p) {
            var e = document.getElementById('dropDownCnae');
            var d = ['block', 'none'];

            e.style.display = d[p];

            var t = ['0px', '0px,-10px'];

            setTimeout(function() {
                e.style.transform = 'translate(' + t[p] + ')'
            }, 0);
        }
    </script>
@endsection

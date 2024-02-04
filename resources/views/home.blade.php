@extends('layouts.app')

@section('content')
    <style>
        .card {}
    </style>
    <div class="container">
        <div class="row row-cols-4">
            @if (auth()->check() and auth()->user()->admin)
                <div class="col">
                    <div class="col card">
                        <div class="card-body" style="height: 153px;">
                            <h5 class="card-title">Orgãos públicos</h5>
                            <p class="card-text">Lista e inclusão de novos clientes.</p>
                            <a href="{{ route('townhalls.listarTudo') }}" class="btn btn-primary">Ver mais</a>
                        </div>
                    </div>
                </div>
            @else
                <div class="col">
                    <div class="col card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $op->cidade }}</h5>
                            <div class="mt-3">
                                Responsável<br> <b>{{ $op->responsavel }}</b>
                            </div>
                        </div>
                        <small class="card-footer text-muted">
                            Telefone para contato {{ $op->fone }}
                        </small>
                    </div>
                </div>
            @endif

            <div class="col">
                <div class="col card">
                    <div class="card-body">
                        <div class="text-center mt-3">
                            <h3>{{ $qtdUsuario }}</h3>
                            <h5 class="card-title ">usuários</h5>
                        </div>
                    </div>
                    <small class="card-footer text-muted">
                        Dados de {{ date('d/m/Y', strtotime($dataInicio)) }} a {{ date('d/m/Y', strtotime($dataAtual)) }}
                    </small>
                </div>
            </div>
            <div class="col">
                <div class="col card">
                    <div class="card-body">
                        <div class="text-center mt-3">
                            <h3>{{ $qtdDispensa }}</h3>
                            <h5 class="card-title">despesas</h5>
                        </div>
                    </div>
                    <small class="card-footer text-muted">
                        Dados de {{ date('d/m/Y', strtotime($dataInicio)) }} a {{ date('d/m/Y', strtotime($dataAtual)) }}
                    </small>
                </div>
            </div>
            <div class="col">
                <div class="col card">
                    <div class="card-body ">
                        <div class="text-center mt-3">
                            <h3><small class="align-top fs-6">R$ </small>{{ number_format($valorGasto, 0, ',', '.') }}</h3>
                            <h5 class="card-title">custo total</h5>
                        </div>
                    </div>
                    <small class="card-footer text-muted">
                        Atualizado em {{ date('d/m/Y H:i:s', strtotime($ultimaAtualizacaoDispensa)) }}
                    </small>
                </div>
            </div>
        </div>

        <div class="col card mt-4">
            <div class="card-body row">
                <h5 class="card-title mb-1">Consulta rápida</h5>
                <div class="p-2">
                    <input type="text" name="sub_classe_cnae" id="sub_classe_cnae" oninput="encontrarCnae()"
                        onclick="limpar()" class="form-control"
                        placeholder="Digite no minímo 3 caracteres para iniciar a busca por subclasses"
                        onblur="dropDownCnae(1)">

                    <div id="dropDownCnae" class="dropDownCnae" style="position: absolute; max-height: 200px;">
                        <div id="listDropDownCnae" class="listDropDownCnae">

                        </div>


                    </div>
                </div>
                <div id="subclasseSelecionada" class="subclasseSelecionada p-2">
                    <div class="card p-4">
                        <div class="toast-header">
                            <strong class="me-auto">Dados da subclasse</strong>
                            <button type="button" class="btn-close" aria-label="Close" onclick="colapseSubSel(1)"></button>
                        </div>
                        <div id="idSubclasse"></div>
                        <hr>
                        <div id="atividadeSubclasse"></div>
                        <hr>
                        <div id="subClasseCompreende" class="mb-3"></div>
                        <div id="subClasseCompreendeAinda" class="mb-3"></div>
                        <div id="subclasseNaoCompreende" class="mb-3"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <script type="text/javascript" src="https://fastly.jsdelivr.net/npm/echarts@5.3.3/dist/echarts.min.js"></script>
            <div class="col-sm-6">
                <div class="col card" style="height: 100%;">
                    <div class="card-body row">
                        <h5 class="card-title mb-1">Valor por modalidade</h5>

                        <div class="col-sm-6" id="main" style="min-height: 180px;"></div>
                        <div class="col-sm-6">
                            <table class="table table-sm">
                                <thead>
                                    <th>Modalidade</th>
                                    <th class="text-center">Despesas</th>
                                    <th class="d-flex flex-row-reverse">Valor (R$)</th>
                                </thead>
                                <tbody>

                                    @foreach ($gastoPorModalidade as $item)
                                        <tr>
                                            <td>{{ $item->modalidade }}</td>
                                            <td class="text-center">{{ $item->qtdModalidade }}</td>
                                            <td>{{ number_format($item->soma, 2, ',', '.') }} </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <small class="card-footer text-muted">
                        Dados de {{ date('d/m/Y', strtotime($dataInicio)) }} a {{ date('d/m/Y', strtotime($dataAtual)) }}
                    </small>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="col card" style="height: 100%;">
                    <div class="card-body row">
                        <h5 class="card-title mb-1">Valor por grupo</h5>


                        <div class="col-sm-6" id="container-gasto-por-produto" style="min-height: 180px;">
                        </div>

                        <div class="col-sm-6">
                            <table class="table table-sm">
                                <thead>
                                    <th>Grupo</th>
                                    <th class="text-center">Despesas</th>
                                    <th class="d-flex flex-row-reverse">Valor (R$)</th>
                                </thead>
                                <tbody>

                                    @foreach ($gastoPorGrupo as $item)
                                        <tr>
                                            <td>{{ $item->grupo_despesa }}</td>
                                            <td class="text-center">{{ $item->qtdDispensa }}</td>
                                            <td>{{ number_format($item->soma, 2, ',', '.') }} </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <small class="card-footer text-muted">
                        Dados de {{ date('d/m/Y', strtotime($dataInicio)) }} a {{ date('d/m/Y', strtotime($dataAtual)) }}
                    </small>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-sm">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Ranking de gasto por subclasse</h5>
                        <table class="table table-sm">
                            <thead>
                                <th>Subclasse</th>
                                <th class="text-center">Qtd. de despesas</th>
                                <th class="d-flex flex-row-reverse">Valor</th>
                            </thead>
                            <tbody>

                                @foreach ($rankingGastoCnae as $item)
                                    <tr>
                                        <td>{{ $item->sub_classe_cnae }}</td>
                                        <td class="text-center">{{ $item->qtd }}</td>
                                        <td class="d-flex flex-row-reverse">R$
                                            {{ number_format($item->soma, 2, ',', '.') }} </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                    <small class="card-footer text-muted">
                        Dados de {{ date('d/m/Y', strtotime($dataInicio)) }} a {{ date('d/m/Y', strtotime($dataAtual)) }}
                    </small>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col">
                <div class="card">
                    <div class="card-body">

                        <h5 class="card-title">Ranking de gasto por processo</h5>
                        <table class="table table-sm">
                            <thead>
                                <th>Número do processo</th>
                                <th>Discriminação</th>
                                <th class="d-flex flex-row-reverse">Valor</th>
                            </thead>
                            <tbody>

                                @foreach ($rankingGastoProcesso as $item)
                                    <tr>
                                        <td>{{ $item->numero_processo_licitatorio }}</td>
                                        <td>{{ $item->discriminacao }}</td>
                                        <td class="d-flex flex-row-reverse">R$
                                            {{ number_format($item->valor, 2, ',', '.') }} </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <small class="card-footer text-muted">
                        Dados de {{ date('d/m/Y', strtotime($dataInicio)) }} a {{ date('d/m/Y', strtotime($dataAtual)) }}
                    </small>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var dom = document.getElementById('container-gasto-por-produto');
        var myChart = echarts.init(dom, null, {
            renderer: 'canvas',
            useDirtyRect: false
        });
        var app = {};

        var option;

        option = {

            tooltip: {
                trigger: 'item',
                position: 'right'
            },
            legend: {
                orient: 'vertical',
                bottom: 0,
                left: 'left'
            },
            series: [{
                name: 'Valor gasto (R$)',
                type: 'pie',
                radius: ['80%'],
                left: 120,
                bottom: 30,
                data: [
                    {{ $jsonPorGrupo }}
                ],
                emphasis: {
                    itemStyle: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                }
            }]
        };

        if (option && typeof option === 'object') {
            myChart.setOption(option);
        }

        window.addEventListener('resize', myChart.resize);
    </script>

    <script type="text/javascript">
        var dom = document.getElementById('main');
        var myChart = echarts.init(dom, null, {
            renderer: 'canvas',
            useDirtyRect: false
        });
        var app = {};

        var option;

        option = {
            tooltip: {
                trigger: 'item',
                position: 'right'
            },
            legend: {
                orient: 'vertical',
                bottom: 0,
                left: 'left'
            },
            series: [{
                name: 'Valo gasto (R$)',
                type: 'pie',
                radius: ['40%', '80%'],
                left: 120,
                bottom: 20,
                avoidLabelOverlap: false,
                label: {
                    show: false,
                    position: 'center'
                },
                emphasis: {
                    label: {
                        show: false,
                        fontSize: '10',
                        fontWeight: 'bold'
                    }
                },
                labelLine: {
                    show: true
                },
                data: [
                    {{ $jsonPorModalidade }}
                ]
            }]
        };

        if (option && typeof option === 'object') {
            myChart.setOption(option);
        }

        window.addEventListener('resize', myChart.resize);

        function limpar() {
            document.getElementById('sub_classe_cnae').value = "";
        }

        function select(a) {

            colapseSubSel(0);

            var dados = document.getElementById(a);

            var retorno = dados.innerHTML.split("·");

            var obs = dados.getAttribute('title');

            document.getElementById('idSubclasse').innerHTML = "Identificação da subclasse <br> <h5>" + retorno[0] +
                "</h5>";
            document.getElementById('atividadeSubclasse').innerHTML = "Atividade <br> <h5>" + retorno[1] + "</h5>";

            if (dados.hasAttribute('data-compreende')) {
                var dtCompreende = dados.dataset['compreende'].split('Esta subclasse compreende');
                document.getElementById('subClasseCompreende').innerHTML = "<h5><b>Esta subclasse compreende</b></h5>" +
                    dtCompreende[1].replace(/\n/g, '<br />');
            }

            if (dados.hasAttribute('data-compreende_ainda')) {
                var dtCompreendeAinda = dados.dataset['compreende_ainda'].split('Esta subclasse compreende ainda');
                document.getElementById('subClasseCompreendeAinda').innerHTML =
                    "<h5><b>Esta subclasse compreende ainda</b></h5>" + dtCompreendeAinda[1].replace(/\n/g, '<br />');
            }

            if (dados.hasAttribute('data-nao_compreende')) {
                var dtNaoCompreende = dados.dataset['nao_compreende'].split('Esta subclasse NÃO compreende');
                document.getElementById('subclasseNaoCompreende').innerHTML =
                    "<h5><b>Esta subclasse não compreende</b></h5>" + dtNaoCompreende[1].replace(/\n/g, '<br />');
            }

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

        function colapseSubSel(p) {
            var e = document.getElementById('subclasseSelecionada');
            var d = ['block', 'none'];

            e.style.display = d[p];

            var t = ['0px', '0px,-10px'];

            setTimeout(function() {
                e.style.transform = 'translate(' + t[p] + ')'
            }, 0);

            if (p == 1) {
                limpar();
            }
        }
    </script>
@endsection

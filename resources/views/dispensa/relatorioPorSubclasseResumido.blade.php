@extends('layouts.app')
@section('content')
    <style>
        .tr-back {
            background-color: #e9edf1;
        }

        .tb-group {
            border: solid #e9edf1;
        }

        .table> :not(:first-child) {
            border-top: none;
        }
    </style>
    <h3 class="ms-5 me-5">Relação por subclasse resumido</h3>
    <nav class="ms-5 me-5" style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item ms-1 me-1"><a href="{{ route('home') }}"><i class="bi bi-house me-1"></i>Página
                    inicial</a></li><i class="bi bi-chevron-right"></i>
            <li class="breadcrumb-item ms-1 me-1 active" aria-current="page"><i class="bi bi-view-stacked me-1"></i>Relação
                por subclasse resumido</li>
        </ol>
    </nav>
    <div class="card ms-5 me-5" style="border-radius:10px;">
        <form action="{{ route('relatorio.porSubclasseResumido') }}" method="get">

            <div class="card-body">
                <div class="row gx-2">
                    <div class="col-3 mb-3 ">
                        <label for="pesquisar" class="form-label">Pesquisar despesa</label>
                        <input type="text" class="form-control" name="pesquisar" id="pesquisar"
                            placeholder="Pesquisar por subclasse" alt="Pesquisar por subclasse"
                            title="Pesquisar por subclasse">
                    </div>

                    <div class="col mb-3">
                        <label for="data-inicial" class="form-label">Data inicial</label>
                        <input type="date" class="form-control" name="dataInicial" id="dataInicial"
                            placeholder="dd/mm/aaaa" alt="Data inicial" title="Data inicial">
                    </div>
                    <div class="col mb-3">
                        <label for="data-final" class="form-label">Data final</label>
                        <input type="date" class="form-control" name="dataFinal" id="dataFinal" placeholder="dd/mm/aaaa"
                            alt="Data final" title="Data final">
                    </div>

                    <div class="col mb-3  d-flex align-items-end">
                        <button href="#" class="btn btn-primary" type="submit"><i
                                class="bi bi-search me-2"></i>Pesquisar</button>
                    </div>

                    <div class="col mb-3 d-flex align-items-end">
                        <a href="{{ action('App\Http\Controllers\PDFController@gerarPdfPorSubclasseResumido') }}?pesquisar={{ request()->get('pesquisar', '') }}&dataInicial={{ request()->get('dataInicial', '') }}&dataFinal={{ request()->get('dataFinal', '') }}"
                            class="btn btn-primary ms-auto  me-2" style="min-width: 145px;" target="_blank"><i
                                class="bi bi-printer me-2"></i>Exportar PDF</a>

                    </div>
                </div>
        </form>
        <p class="border rounded p-2">Quantidade total de despesas: <b>{{ $dispensa->total() }}</b><span
                class="ms-2 me-2">|</span>Valor
            total: <b>{{ 'R$ ' . number_format($totalSoma, 2, ',', '.') }}</b></p>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Subclasse</th>
                    <th scope="col" class="text-center">Quantidade de despesas</th>
                    <th scope="col" class="text-end">Valor total das despesas</th>
                    <th scope="col" class="text-end">Valor disponível na subclasse</th>

                </tr>
            </thead>

            @foreach ($dispensa->groupby('sub_classe_cnae') as $subclasse => $items)
                <?php
                
                $sum = 0;
                $qtd = 0;
                $dst = [];
                $valorDispensa = '';
                
                foreach ($items as $key) {
                    $sum += $key->valor;
                    $dst[] = $key->grupo_despesa;
                }
                
                $qtd = count($items);
                
                $unique = count(array_unique($dst));
                
                if ($unique != 1) {
                    $valorDispensa = '';
                } else {
                    if (reset($dst) == 'Compras e Serviços') {
                        $valorDispensa = $config->aquis_servicos;
                    } else {
                        $valorDispensa = $config->obras_eng_man_vei;
                    }
                }
                
                array_diff($dst);
                
                ?>
                <tr>
                    <td>
                        {{ $subclasse }}
                    </td>
                    <td class="text-center">
                        {{ $qtd }}
                    </td>

                    <td class="text-end">
                        {{ 'R$ ' . number_format($sum, 2, ',', '.') }}
                    </td>

                    <td class="text-end">
                        @if ($valorDispensa != '')
                            {{ 'R$ ' . number_format($valorDispensa - $sum, 2, ',', '.') }}
                        @else
                            Ausente por divergência de classificação
                        @endif

                    </td>
                </tr>
            @endforeach
        </table>
        <div class="row">

            <?php $dispensa->appends([
                'pesquisar' => request()->get('pesquisar', ''),
                'dataInicial' => request()->get('dataInicial', ''),
                'dataFinal' => request()->get('dataFinal', ''),
                'modalidade' => request()->get('modalidade', ''),
                'grupo' => request()->get('grupo', ''),
            ]); ?>
            <nav class="row pt-3">
                <div class="col align-middle">
                    @if ($dispensa->lastPage() > 1)
                        <ul class="pagination pagination-sm">
                            <li class="page-item me-2 {{ $dispensa->currentPage() == 1 ? ' disabled' : '' }}">
                                <a style="border-radius: 4px;" class="page-link" href="{{ $dispensa->url(1) }}"><i
                                        class="bi bi-chevron-left me-2"></i> Primeira</a>
                            </li>
                            <li class="page-item {{ $dispensa->currentPage() == 1 ? ' disabled' : '' }}">
                                <a class="page-link" href="{{ $dispensa->url($dispensa->currentPage() - 1) }}">Anterior</a>
                            </li>
                            @for ($i = 1; $i <= $dispensa->lastPage(); $i++)
                                <li class="page-item  {{ $dispensa->currentPage() == $i ? ' active' : '' }}">
                                    <a class="page-link" href="{{ $dispensa->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor
                            <li
                                class=" page-item {{ $dispensa->currentPage() == $dispensa->lastPage() ? ' disabled' : '' }}">
                                <a class="page-link" href="{{ $dispensa->url($dispensa->currentPage() + 1) }}">Próxima</a>
                            </li>
                            <li
                                class="page-item ms-2 {{ $dispensa->currentPage() == $dispensa->lastPage() ? ' disabled' : '' }}">
                                <a class="page-link" href="{{ $dispensa->url($dispensa->lastPage()) }}">Ultima <i
                                        class="bi bi-chevron-right ms-2"></i></a>
                            </li>
                        </ul>
                    @endif
                </div>
                <div class="col align-items-baseline d-flex align-items-end">
                    <div class="ms-auto align-top">Exibindo {{ $dispensa->firstItem() }} a
                        {{ $dispensa->lastItem() }} de
                        {{ $dispensa->total() }} despesas.</div>
                </div>
            </nav>
        </div>
    </div>
    </div>
@endsection

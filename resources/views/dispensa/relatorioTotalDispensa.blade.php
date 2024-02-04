@extends('layouts.app')

@section('content')
    <h3 class="ms-5 me-5">Relação total de despesas</h3>
    <nav class="ms-5 me-5" style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item ms-1 me-1"><a href="{{ route('home') }}"><i class="bi bi-house me-1"></i>Página
                    inicial</a></li><i class="bi bi-chevron-right"></i>
            <li class="breadcrumb-item ms-1 me-1 active" aria-current="page"><i class="bi bi-list me-1"></i>Relação total de
                despesas</li>
        </ol>
    </nav>
    <div class="card ms-5 me-5" style="border-radius:10px;">
        <form action="{{ route('relatorio.totalDispensa') }}" method="get">

            <div class="card-body">
                <div class="row gx-2">
                    <div class="col-3 mb-3 ">
                        <label for="pesquisar" class="form-label">Pesquisar despesa</label>
                        <input type="text" class="form-control" name="pesquisar" id="pesquisar"
                            placeholder="Discriminação, processo licitatório ou código da subclasse"
                            alt="Discriminação, processo licitatório ou código da subclasse"
                            title="Discriminação, processo licitatório ou código da subclasse">
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

                    <div class="col mb-3">
                        <label for="modalidade" class="form-label">Modalidade</label>

                        <select name="modalidade" style="width: 100%" class="form-select " id="modalidade">
                            <option value="">Todas
                            </option>
                            <option value="Concorrência">Concorrência
                            </option>
                            <option value="Dispensa">Dispensa</option>
                            <option value="Inexigibilidade">Inexigibilidade</option>
                            <option value="Pregão">Pregão</option>
                            <option value="Tomada de preço">Tomada de
                                preço</option>

                        </select>
                    </div>
                    <div class="col mb-3">
                        <label for="grupo" class="form-label">Grupo</label>

                        <select name="grupo" style="width: 100%" class="form-select " id="modalidade">
                            <option value="">Todos
                            </option>
                            <option value="Compras e Serviços">Compras e Serviços
                            </option>
                            <option value="Obras, serv. Engenharia e veículos">Obras, serv. eng. e veí</option>


                        </select>
                    </div>

                    <div class="col mb-3  d-flex align-items-end">
                        <button href="#" class="btn btn-primary" type="submit"><i
                                class="bi bi-search me-2"></i>Pesquisar</button>
                    </div>

                    <div class="col mb-3 d-flex align-items-end">
                        <a href="{{ action('App\Http\Controllers\PDFController@gerarPdfTotalDispensa') }}?pesquisar={{ request()->get('pesquisar', '') }}&dataInicial={{ request()->get('dataInicial', '') }}&dataFinal={{ request()->get('dataFinal', '') }}&modalidade={{ request()->get('modalidade', '') }}&grupo={{ request()->get('grupo', '') }}"
                            class="btn btn-primary ms-auto  me-2" style="min-width: 145px;" target="_blank"><i
                                class="bi bi-printer me-2"></i>Exportar PDF</a>

                    </div>
                </div>
        </form>

        <p class="border rounded p-2">Quantidade total de despesas: <b>{{ $dispensa->total() }}</b><span
                class="ms-2 me-2">|</span>Valor
            total: <b>{{ 'R$ ' . number_format($totalSoma, 2, ',', '.') }}</b></p>
        <table class="table table-striped" style="border-radius: 8px;">
            <thead>
                <tr>
                    <th scope="col">Número da despesa</th>
                    <th scope="col">Processo licitatório</th>
                    <th scope="col">Valor</th>
                    <th scope="col">Modalidade</th>
                    <th scope="col">Grupo de despesa</th>
                    <th scope="col">Usuário</th>
                    <th scope="col">Data de criação</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dispensa as $item)
                    <tr class="align-middle">

                        <td>
                            {{ $item->numero_dispensa }}

                        </td>
                        <td>
                            {{ $item->numero_processo_licitatorio }}

                        </td>
                        <td>
                            {{ 'R$ ' . number_format($item->valor, 2, ',', '.') }}

                        </td>
                        <td>
                            {{ $item->modalidade }}

                        </td>
                        <td>
                            {{ $item->grupo_despesa }}

                        </td>
                        <td title="Matricula do usuário: {{ $item->matricula }}">
                            {{ $item->name }}

                        </td>
                        <td>
                            {{ date('d/m/Y H:i:s ', strtotime($item->created_at)) }}

                        </td>
                    </tr>
                    <tr class="table-bordered">
                        <td colspan="7">
                            <table class="table mb-0 ">
                                <tr>
                                    <td width="50%">
                                        <b>Discriminação</b><br> {{ $item->discriminacao }}
                                    </td>
                                    <td>
                                        <b>Subclasse do cnae</b><br> {{ $item->sub_classe_cnae }} · {{ $item->atividade }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                @endforeach

            </tbody>

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
                                <a class="page-link"
                                    href="{{ $dispensa->url($dispensa->currentPage() - 1) }}">Anterior</a>
                            </li>
                            @for ($i = 1; $i <= $dispensa->lastPage(); $i++)
                                <li class="page-item  {{ $dispensa->currentPage() == $i ? ' active' : '' }}">
                                    <a class="page-link" href="{{ $dispensa->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor
                            <li
                                class=" page-item {{ $dispensa->currentPage() == $dispensa->lastPage() ? ' disabled' : '' }}">
                                <a class="page-link"
                                    href="{{ $dispensa->url($dispensa->currentPage() + 1) }}">Próxima</a>
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

@extends('layouts.app')

@section('content')
    <h3 class="ms-5 me-5">Log de alterações</h3>
    <nav class="ms-5 me-5" style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item ms-1 me-1"><a href="{{ route('home') }}"><i class="bi bi-house me-1"></i>Página
                    inicial</a></li><i class="bi bi-chevron-right"></i>
            <li class="breadcrumb-item ms-1 me-1 active" aria-current="page"><i class="bi bi-card-list me-1"></i>Log de
                alterações</li>
        </ol>
    </nav>

    <div class="card ms-5 me-5" style="border-radius:10px;">
        <form action="{{ route('logs.alteracoes') }}" method="get">
            <div class="card-body">
                <div class="row gx-2">
                    <div class="col-4 mb-3 ">
                        <label for="pesquisar" class="form-label">Pesquisar alteração</label>
                        <input type="text" class="form-control" name="pesquisar" id="pesquisar"
                            placeholder="Alteração que deseja encontrar" alt="Alteração que deseja encontrar"
                            title="Alteração que deseja encontrar">
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
                </div>
        </form>

        <table class="table table-striped" style="border-radius: 8px;">
            <thead>
                <tr>
                    <th scope="col">Usuário</th>
                    <th scope="col">Produto</th>
                    <th scope="col">Módulo</th>
                    <th scope="col">Processo</th>
                    <th scope="col">Data de alteração</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logs as $item)
                    <tr class="align-middle">

                        <td>
                            {{ $item->name }}

                        </td>
                        <td>
                            {{ $item->produto }}

                        </td>
                        <td>
                            {{ $item->tabela }}

                        </td>
                        <td>
                            {{ $item->processo }}

                        </td>
                        <td>
                            {{ date('d/m/Y H:i:s ', strtotime($item->created_at)) }}
                        </td>
                    </tr>
                    <tr class="table-bordered">
                        <td colspan="5">
                            <table class="table mb-0 ">
                                <tr>
                                    <td>
                                        <b>Alteração</b><br> <?php echo nl2br($item->alteracao); ?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="row">
            <?php $logs->appends([
                'pesquisar' => request()->get('pesquisar', ''),
                'dataInicial' => request()->get('dataInicial', ''),
                'dataFinal' => request()->get('dataFinal', ''),
            ]); ?>
            <nav class="row pt-3">
                <div class="col align-middle">
                    @if ($logs->lastPage() > 1)
                        <ul class="pagination pagination-sm">
                            <li class="page-item me-2 {{ $logs->currentPage() == 1 ? ' disabled' : '' }}">
                                <a style="border-radius: 4px;" class="page-link" href="{{ $logs->url(1) }}"><i
                                        class="bi bi-chevron-left me-2"></i> Primeira</a>
                            </li>
                            <li class="page-item {{ $logs->currentPage() == 1 ? ' disabled' : '' }}">
                                <a class="page-link" href="{{ $logs->url($logs->currentPage() - 1) }}">Anterior</a>
                            </li>
                            @for ($i = 1; $i <= $logs->lastPage(); $i++)
                                <li class="page-item  {{ $logs->currentPage() == $i ? ' active' : '' }}">
                                    <a class="page-link" href="{{ $logs->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor
                            <li class=" page-item {{ $logs->currentPage() == $logs->lastPage() ? ' disabled' : '' }}">
                                <a class="page-link" href="{{ $logs->url($logs->currentPage() + 1) }}">Próxima</a>
                            </li>
                            <li class="page-item ms-2 {{ $logs->currentPage() == $logs->lastPage() ? ' disabled' : '' }}">
                                <a class="page-link" href="{{ $logs->url($logs->lastPage()) }}">Ultima <i
                                        class="bi bi-chevron-right ms-2"></i></a>
                            </li>
                        </ul>
                    @endif
                </div>
                <div class="col align-items-baseline d-flex align-items-end">
                    <div class="ms-auto align-top">Exibindo {{ $logs->firstItem() }} a
                        {{ $logs->lastItem() }} de
                        {{ $logs->total() }} resultados.</div>
                </div>
            </nav>
        </div>
    </div>
    </div>
@endsection

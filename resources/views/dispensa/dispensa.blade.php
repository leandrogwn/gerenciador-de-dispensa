@extends('layouts.app')

@section('content')
    <h3 class="ms-5 me-5">Lista de despesas</h3>
    <nav class="ms-5 me-5" style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item ms-1 me-1"><a href="{{ route('home') }}"><i class="bi bi-house me-1"></i>Página
                    inicial</a></li><i class="bi bi-chevron-right"></i>
            <li class="breadcrumb-item ms-1 me-1 active" aria-current="page"><i class="bi bi-people me-1"></i>Lista de
                despesas</li>
        </ol>
    </nav>
    <div class="card ms-5 me-5" style="border-radius:10px;">
        <form action="{{ route('dispensa.show') }}" method="get">

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
                        <a href="{{ action('App\Http\Controllers\DispensaController@create') }}"
                            class="btn btn-primary ms-auto" style="min-width: 145px;"><i class="bi bi-plus-lg me-2"></i>Nova
                            despesa</a>
                    </div>
                </div>
        </form>
        <hr>

        <table class="table table-striped" style="border-radius: 8px;">
            <thead>
                <tr>
                    <th scope="col">Número</th>
                    <th scope="col">Processo licitatório</th>
                    <th scope="col">Valor</th>
                    <th scope="col">Modalidade</th>
                    <th scope="col">Usuário</th>
                    <th scope="col">Data de criação</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dispensa as $item)
                    <tr class="align-middle">

                        <td title="Identity Id: {{ $item->identity_id }}">
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
                        <td title="Matricula do usuário: {{ $item->matricula }}">
                            {{ $item->name }}

                        </td>
                        <td>
                            {{ date('d/m/Y H:i:s ', strtotime($item->created_at)) }}

                        </td>
                        <td class="d-flex flex-row-reverse">
                            <a class="btn btn-sm btn-outline-primary ms-1"
                                href="{{ action('App\Http\Controllers\DispensaController@edit', $item->id) }}"><i
                                    class="bi bi-pencil-square me-2"></i>Editar</a>

                            <form method="POST" action="{{ route('dispensa.destroy', $item->id) }}">
                                @csrf
                                <input name="_method" type="hidden" value="DELETE">
                                <button type="submit" id="btn-excluir"
                                    class="btn btn-sm btn-outline-danger show-alert-delete-box" data-toggle="tooltip"
                                    data-bs-name="{{ $item->numero_dispensa }}" title='Delete'>
                                    <i class="bi bi-trash3 me-2"></i>Excluir</button>
                            </form>
                        </td>
                    </tr>
                    <tr class="table-bordered">
                        <td colspan="7">
                            <table class="table mb-0 ">
                                <tr>
                                    <td width="25%">
                                        <b>Grupo de despesa</b><br> {{ $item->grupo_despesa }}
                                    </td>
                                    <td width="25%">
                                        <b>Discriminação</b><br> {{ $item->discriminacao }}
                                    </td>
                                    <td width="50%">
                                        <b>Subclasse do cnae</b><br> {{ $item->sub_classe_cnae }} · {{ $item->atividade }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                @endforeach

            </tbody>

        </table>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

        <script type="text/javascript">
            $('.show-alert-delete-box').click(function(event) {
                const button = event.relatedTarget
                var form = $(this).closest("form");
                var numero = $(this).attr("data-bs-name");
                event.preventDefault();
                swal({
                    title: `Exclusão de dispensa`,
                    text: `Confirma a exclusão da dispensa número  ${numero} ?`,
                    icon: "warning",
                    type: "warning",
                    buttons: ["Cancelar", "Confirmar"],
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    }

                });
            });
        </script>
        @if (session('mensagem'))
            <script>
                swal("Dispensa excluída com sucesso!", {
                    icon: "success",
                    buttons: false
                });
            </script>
        @endif
        <div class="row">

            <?php $dispensa->appends([
                'pesquisar' => request()->get('pesquisar', ''),
                'dataInicial' => request()->get('dataInicial', ''),
                'dataFinal' => request()->get('dataFinal', ''),
                'modalidade' => request()->get('modalidade', ''),
                'grupo' => request()->get('grupo',''),
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

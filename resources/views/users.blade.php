@extends('layouts.app')

@section('content')

    <h3 class="ms-5 me-5">Lista de usuários</h3>
    <nav class="ms-5 me-5" style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item ms-1 me-1"><a href="{{ route('home') }}"><i class="bi bi-house me-1"></i>Página
                    inicial</a></li><i class="bi bi-chevron-right"></i>
            <li class="breadcrumb-item ms-1 me-1 active" aria-current="page"><i class="bi bi-people me-1"></i>Lista de
                usuários</li>
        </ol>
    </nav>
    <div class="card ms-5 me-5" style="border-radius:10px;">
        <form action="{{ route('users.listarTudo') }}" method="get">

            <div class="card-body">
                <div class="row">
                    <div class="col mb-3">
                        <label for="pesquisar" class="form-label">Pesquisar usuários</label>
                        <input type="text" class="form-control" style="min-width: 27rem" name="pesquisar" id="pesquisar"
                            placeholder="Informe o nome ou a matrícula do usuário">
                    </div>
                    <div class="col mb-3 d-flex align-items-end">
                        <button href="#" class="btn btn-primary" type="submit"><i
                                class="bi bi-search me-2"></i>Pesquisar</button>
                    </div>
        </form>
        <div class="col  mb-3 d-flex align-items-end">
            <a href="{{ action('App\Http\Controllers\UsersController@novoUsuario') }}" class="btn btn-primary ms-auto"><i
                    class="bi bi-plus-lg me-2"></i>Novo
                usuário</a>

        </div>
    </div>
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">Nome</th>
                <th scope="col">Matrícula</th>
                <th scope="col">Perfil</th>
                <th scope="col">E-mail</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $item)
                <tr class="align-middle">
                    <td>
                        {{ $item->name }}

                    </td>
                    <td>
                        {{ $item->matricula }}

                    </td>
                    <td>
                        {{ $item->perfil }}

                    </td>
                    <td>
                        {{ $item->email }}

                    </td>
                    <td class="d-flex flex-row-reverse">
                        <a class="btn btn-sm btn-outline-primary ms-1"
                            href="{{ action('App\Http\Controllers\UsersController@editarUsuario', $item->id) }}"><i
                                class="bi bi-pencil-square me-2"></i>Editar</a>
                        <form method="POST" action="{{ route('users.excluirUsuario', $item->id) }}">
                            @csrf
                            <input name="_method" type="hidden" value="DELETE">
                            <button type="submit" id="btn-excluir"
                                class="btn btn-sm btn-outline-danger show-alert-delete-box" data-toggle="tooltip"
                                data-bs-name="{{ $item->name }}" title='Delete'>
                                <i class="bi bi-trash3 me-2"></i>Excluir</button>
                        </form>
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
            var nome = $(this).attr("data-bs-name");
            event.preventDefault();
            swal({
                title: `Exclusão de usuário`,
                text: `Confirma a exclusão do usuário ${nome} ?`,
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
            swal("Usuário excluído com sucesso!", {
                icon: "success",
                buttons: false
            });
        </script>
    @endif

    <div class="row">

        <?php $users->appends([
            'pesquisar' => request()->get('pesquisar', ''),
        ]); ?>
        <nav class="row pt-3">
            <div class="col align-middle">
                @if ($users->lastPage() > 1)
                    <ul class="pagination pagination-sm">
                        <li class="page-item me-2 {{ $users->currentPage() == 1 ? ' disabled' : '' }}">
                            <a style="border-radius: 4px;" class="page-link" href="{{ $users->url(1) }}"><i
                                    class="bi bi-chevron-left me-2"></i> Primeira</a>
                        </li>
                        <li class="page-item {{ $users->currentPage() == 1 ? ' disabled' : '' }}">
                            <a class="page-link" href="{{ $users->url($users->currentPage() - 1) }}">Anterior</a>
                        </li>
                        @for ($i = 1; $i <= $users->lastPage(); $i++)
                            <li class="page-item  {{ $users->currentPage() == $i ? ' active' : '' }}">
                                <a class="page-link" href="{{ $users->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor
                        <li class=" page-item {{ $users->currentPage() == $users->lastPage() ? ' disabled' : '' }}">
                            <a class="page-link" href="{{ $users->url($users->currentPage() + 1) }}">Próxima</a>
                        </li>
                        <li class="page-item ms-2 {{ $users->currentPage() == $users->lastPage() ? ' disabled' : '' }}">
                            <a class="page-link" href="{{ $users->url($users->lastPage()) }}">Ultima <i
                                    class="bi bi-chevron-right ms-2"></i></a>
                        </li>
                    </ul>
                @endif
            </div>
            <div class="col align-items-baseline d-flex align-items-end">
                <div class="ms-auto align-top">Exibindo {{ $users->firstItem() }} a {{ $users->lastItem() }} de
                    {{ $users->total() }} resultados.</div>
            </div>
        </nav>
    </div>
    </div>
    </div>
@endsection

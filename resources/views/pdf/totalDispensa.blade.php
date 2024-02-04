<!doctype html>

<head>
    <meta charset="utf-8">
    <title>{{ __('Relação total de despesas') }}</title>
    <style>
        body {
            font-size: 10px;
            font-family: 'Nunito', sans-serif;
        }

        .tot-top {
            padding: 1rem;
            border: solid 2px #AEABAA;
            border-radius: 4px;
            vertical-align: middle !important;
        }

        .ms-2 {
            margin-left: 1rem !important;
        }

        .me-2 {
            margin-right: 1rem !important;
        }

        th {
            text-align: inherit;
            border-bottom: 1px solid rgb(58, 58, 58);
            padding-left: 5px;
            padding-right: 5px;
            padding-top: 5px;
            vertical-align: bottom;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        #linha1 {
            background-color: #e9edf1;
            padding: 1rem !important;
        }

        #linha2 {
            width: 100% !important;
        }

        .table {
            border-collapse: collapse;
        }

        #table2 {
            width: 100%;
            border-left: 1px solid #AEABAA;
            border-bottom: 1px solid #AEABAA;
            border-right: 1px solid #AEABAA;
        }

        td {
            padding: 5px;
            border-width: 0px;
        }

        #footer {
            vertical-align: text-bottom
        }

        @page {
            size: auto;
            odd-footer-name: html_myFooter1;
        }
    </style>
</head>

<body>
    <table style="width: 100%">

        <tr>
            <td>
                <p>@include('components.application-logo-nav')</p>
                <p>&nbsp;</p>
                <h3>Órgão público: {{ $op }}</h3>
                @if ($pesquisa != '')
                    <p>
                        <b>Critério de pesquisa usado: </b>{{ $pesquisa }}
                    </p>
                @endif
                @if ($modalidade != '')
                    <p>
                        <b>Modalidade: </b>{{ $modalidade }}
                    </p>
                @endif
                @if ($grupo != '')
                    <p>
                        <b>Grupo: </b>{{ $grupo }}
                    </p>
                @endif

                <p>
                    @if (is_null($dinicial))
                        <b>Período automático:</b>
                        {{ date('d/m/Y H:i:s ', strtotime($data->min('created_at'))) }}
                    @else
                        <b>Período selecionado:</b>
                        {{ date('d/m/Y 00:00:00 ', strtotime($dinicial)) }}
                    @endif
                    -
                    @if (is_null($dfinal))
                        {{ date('d/m/Y H:i:s ', strtotime($data->max('created_at'))) }}
                    @else
                        {{ date('d/m/Y 23:59:59 ', strtotime($dfinal)) }}
                    @endif
                </p>
            </td>
            <td style="text-align:right">
                <div style="float: right; margin-top:2px; font-size: 2rem;">Relação total de despesas</div>
            </td>
        </tr>
    </table>

    <p class="tot-top">Quantidade total de despesas: <b>{{ $data->count() }}</b> <span class="ms-2 me-2">|</span> Valor
        total: <b>{{ 'R$ ' . number_format($data->sum('valor'), 2, ',', '.') }}</b></p>
    <div>

        <table>

            <tr>
                <th scope="col">Número da despesa</th>
                <th scope="col">Processo licitatório</th>
                <th scope="col">Valor</th>
                <th scope="col">Modalidade</th>
                <th scope="col">Grupo de despesa</th>
                <th scope="col">Usuário</th>
                <th scope="col">Data de criação</th>
            </tr>

            @foreach ($data as $item)
                <tr id="linha1" class="table">

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
                <tr>
                    <td colspan="7">
                        <table id="table2">
                            <tr>
                                <td>
                                    <b>Discriminação</b><br> {{ $item->discriminacao }}
                                </td>
                                <td style="width: 50%; text-align: left;">
                                    <b>Subclasse do cnae</b><br> {{ $item->sub_classe_cnae }} ·
                                    {{ $item->atividade }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            @endforeach

        </table>

    </div>
    <htmlpagefooter name="myFooter1" style="display:none">
        <table width="100%">
            <tr>
                <td width="33%">
                    {{ date('d/m/Y H:i:s') }}
                </td>
                <td width="33%" align="center">
                    www.gurskiassessoria.com.br
                </td>
                <td width="33%" style="text-align: right;">
                    Página {PAGENO} de {nbpg}
                </td>
            </tr>
        </table>
    </htmlpagefooter>
</body>

</html>

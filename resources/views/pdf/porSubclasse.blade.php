<!doctype html>

<head>
    <meta charset="utf-8">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('Relação por subclasse') }}</title>
    <style>
        body {
            font-size: 10px;
            font-family: 'Nunito', sans-serif;
        }

        td {
            padding: 5px;
            border-width: 0px;
        }

        .table {
            border-collapse: collapse;
            border: 1px solid #AEABAA;
            width: 100%;
        }

        th {
            text-align: inherit;
            text-align: -webkit-match-parent;
            border-bottom: 1px solid #000;
            vertical-align: bottom;
            padding-top: 5px;
        }

        .table {
            margin-bottom: 1rem;
            vertical-align: top;
            text-align: left;

        }

        #table2 {
            width: 100%;
            border-left: 1px solid #AEABAA;
            border-bottom: 1px solid #AEABAA;
            border-right: 1px solid #AEABAA;
        }

        .ms-2 {
            margin-left: 1rem !important;
        }

        .me-2 {
            margin-right: 1rem !important;
        }

        .align-middle {
            vertical-align: middle !important;
        }

        tr {
            page-break-inside: avoid !important;
        }

        .mb-0 {
            margin-bottom: 0 !important
        }

        .tot-top {
            padding: 1rem;
            border: solid 2px #AEABAA;
            border-radius: 4px;
            vertical-align: middle !important;
        }

        #thead {
            font-weight: bold;
            border-style: solid;
            border-top-style: none;
            border-right-style: none;
            border-left-style: none;
            background: #fff !important;

        }

        .tr-back {
            background-color: #e9edf1 !important;
        }

        .tb-group {
            border: 1px solid #e9edf1;
            border-style: solid;

        }

        .text-end {
            text-align: right !important;
        }

        .text-center {
            text-align: center !important;
        }

        .nome {
            float: right;
            margin-top: 2px;
        }

        .mt {
            margin-top: 1rem;
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
                        {{ date('d/m/Y H:i:s ', strtotime($dispensa->min('created_at'))) }}
                    @else
                        <b>Período selecionado:</b>
                        {{ date('d/m/Y 00:00:00 ', strtotime($dinicial)) }}
                    @endif
                    -
                    @if (is_null($dfinal))
                        {{ date('d/m/Y H:i:s ', strtotime($dispensa->max('created_at'))) }}
                    @else
                        {{ date('d/m/Y 23:59:59 ', strtotime($dfinal)) }}
                    @endif
                </p>

            </td>
            <td style="text-align:right">
                <div style="float: right; margin-top:2px; font-size: 2rem;">Relação por subclasse</div>
            </td>
        </tr>
    </table>

    <p class="tot-top">Quantidade total de despesas: <b>{{ $dispensa->count() }}</b> <span class="ms-2 me-2">|</span>
        Valor total: <b>{{ 'R$ ' . number_format($dispensa->sum('valor'), 2, ',', '.') }}</b></p>

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
                $valorDispensa = $valorCompra;
            } else {
                $valorDispensa = $valorObra;
            }
        }

        array_diff($dst);
        
        ?>
        <div style="border-radius:6px; overflow: hidden;">
            <table class="table tb-group">
                <tr class="tr-back">
                    <td colspan="7"><b>Subclasse:</b> {{ $subclasse }}</td>

                </tr>
                <tr>
                    <th scope="col" style="padding-left: 5px;">Número da dispensa</th>
                    <th scope="col">Processo licitatório</th>
                    <th scope="col">Valor</th>
                    <th scope="col">Modalidade</th>
                    <th scope="col">Grupo de despesa</th>
                    <th scope="col">Usuário</th>
                    <th scope="col">Data de criação</th>
                </tr>
                @foreach ($items as $item)
                    <tbody>
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
                                        <td width="50%">
                                            <b>Discriminação</b><br> {{ $item->discriminacao }}
                                        </td>
                                        <td>
                                            <b>Subclasse do cnae</b><br> {{ $item->sub_classe_cnae }} ·
                                            {{ $item->atividade }}
                                        </td>
                                    </tr>
                                </table>
                            </td>

                        </tr>
                @endforeach

                </tbody>
                <tr class="tr-back">
                    <td colspan="7"><b>Totalizadores</b> <span class="ms-2 me-2">|</span> Valor total:
                        {{ 'R$ ' . number_format($sum, 2, ',', '.') }} <span class="ms-2 me-2">|</span> Quantidade de
                        despesas: {{ $qtd }} <span class="ms-2 me-2">|</span> Valor disponível na subclasse:
                        @if ($valorDispensa != '')
                            {{ 'R$ ' . number_format($valorDispensa - $sum, 2, ',', '.') }}
                        @else
                            Ausente por divergência de classificação
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    @endforeach

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

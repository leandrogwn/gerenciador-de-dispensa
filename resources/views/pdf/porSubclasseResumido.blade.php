<!doctype html>

<head>
    <meta charset="utf-8">

    <title>{{ __('Relação por subclasse resumido') }}</title>
    <style>
        body {
            font-size: 11px;
            font-family: 'Nunito', sans-serif;
        }

        td {
            padding: 5px;
            border-width: 0px;
        }

        table {
            caption-side: bottom;
            border-collapse: collapse;
        }

        th {
            border-bottom: 1px solid;
        }

        caption {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
            color: #6c757d;
            text-align: left;
        }

        th {
            text-align: inherit;
            text-align: -webkit-match-parent;
        }

        .table> :not(caption)>*>* {
            padding: 0.5rem 0.5rem;
            border-bottom-width: 1px;
            box-shadow: inset 0 0 0 9999px;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            margin-right: 5px;
            vertical-align: top;
            text-align: left;
        }


        .ms-2 {
            margin-left: 1rem !important;
        }

        .me-2 {
            margin-right: 1rem !important;
        }

        .table-striped>tbody>tr:nth-of-type(odd) {
            background: #e9edf1;
            color: #212529;
        }

        .table-striped-columns>:not(caption)>tr>:nth-child(2n) {
            color: #212529;
        }

        .align-middle {
            vertical-align: middle !important;
        }

        .table-bordered>:not(caption)>* {
            border-color: #e9edf1;
            color: #212529;
        }

        tr {
            page-break-inside: avoid !important;
        }

        .table-bordered>:not(caption)>*>* {
            border-style: solid;
            border-bottom-width: 1px;
            border-top-style: none;
            border-right-width: 1px;
            border-left-width: 1px;
            padding-left: 10px;
            border-color: #AEABAA;
            padding-left: 10px;
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
            border: solid #e9edf1 !important;
        }

        .table> :not(:first-child) {
            border-top: none !important;
        }

        .text-end {
            text-align: right !important;
        }

        .text-center {
            text-align: center !important;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
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
                <div style="float: right; margin-top:2px; font-size: 2rem;">Relação por subclasse resumido</div>
            </td>
        </tr>
    </table>

    <p class="tot-top">Quantidade total de despesas: <b>{{ $dispensa->count() }}</b> <span class="ms-2 me-2">|</span>
        Valor total: <b>{{ 'R$ ' . number_format($dispensa->sum('valor'), 2, ',', '.') }}</b></p>

    <table class="table">
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
                    $valorDispensa = $valorCompra;
                } else {
                    $valorDispensa = $valorObra;
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Mpdf\Mpdf;

class PDFController extends Controller
{
    public function gerarPdfTotalDispensa(Request $request)
    {
        $identity_id = Auth::user()->identity_id;

        $request->filled('dataInicial') ? $start = Carbon::parse($request->dataInicial)->format('Y-m-d 00:00:00') : $start = Carbon::minValue()->format('Y-m-d 00:00:00');
        $request->filled('dataFinal') ? $end = Carbon::parse($request->dataFinal)->format('Y-m-d 23:59:59') : $end = Carbon::now()->format('Y-m-d 23:59:59');

        $data = DB::table('users')
            ->join('dispensas', 'dispensas.id_user', '=', 'users.id')
            ->havingBetween('dispensas.created_at', [$start, $end])
            ->select(['dispensas.*', 'users.name', 'users.matricula'])
            ->where([
            ['dispensas.identity_id', 'LIKE', "{$identity_id}"],
            ['dispensas.discriminacao', 'LIKE', "%{$request->pesquisar}%"],
            ['dispensas.modalidade', 'LIKE', "%{$request->modalidade}%"],
            ['dispensas.grupo_despesa', 'LIKE', "%{$request->grupo}%"]
        ])->orwhere([
            ['dispensas.identity_id', 'LIKE', "{$identity_id}"],
            ['dispensas.sub_classe_cnae', 'LIKE', "%{$request->pesquisar}%"],
            ['dispensas.modalidade', 'LIKE', "%{$request->modalidade}%"],
            ['dispensas.grupo_despesa', 'LIKE', "%{$request->grupo}%"]
        ])->orwhere([
            ['dispensas.identity_id', 'LIKE', "{$identity_id}"],
            ['dispensas.numero_processo_licitatorio', 'LIKE', "{$request->pesquisar}"],
            ['dispensas.modalidade', 'LIKE', "%{$request->modalidade}%"],
            ['dispensas.grupo_despesa', 'LIKE', "%{$request->grupo}%"]
        ])->get();

        $data = array(
            'data' => $data
        );

        $op = DB::table('townhalls')->where('identity_id', 'like', $identity_id)->select('cidade')->first()->cidade;

        $pesquisa = array(
            'pesquisa' => $request->pesquisar,
            'dinicial' => $request->dataInicial,
            'dfinal' => $request->dataFinal,
            'modalidade' => $request->modalidade,
            'grupo' => $request->grupo,
            'op' => $op
        );

        $pdf = view('pdf.totalDispensa', $data, $pesquisa);

        $mpdf = new \Mpdf\Mpdf([
            'format' => 'A4-P',
            'margin_left' => 8,
            'margin_right' => 8,
            'margin_top' => 23,
            'margin_bottom' => 23,
            'margin_header' => 0,
            'margin_footer' => 15,
        ]);

        $mpdf->WriteHTML($pdf);

        $mpdf->Output(Carbon::now() .'.pdf', \Mpdf\Output\Destination::INLINE);

    }

    public function gerarPdfPorSubclasse(Request $request)
    {
        $identity_id = Auth::user()->identity_id;

        $request->filled('dataInicial') ? $start = Carbon::parse($request->dataInicial)->format('Y-m-d 00:00:00') : $start = Carbon::minValue()->format('Y-m-d 00:00:00');
        $request->filled('dataFinal') ? $end = Carbon::parse($request->dataFinal)->format('Y-m-d 23:59:59') : $end = Carbon::now()->format('Y-m-d 23:59:59');

        $dispensa = DB::table('users')
            ->join('dispensas', 'dispensas.id_user', '=', 'users.id')
            ->havingBetween('dispensas.created_at', [$start, $end])
            ->select(['dispensas.*', 'users.name', 'users.matricula'])
            ->where([
            ['dispensas.identity_id', 'LIKE', "{$identity_id}"],
            ['dispensas.discriminacao', 'LIKE', "%{$request->pesquisar}%"],
            ['dispensas.modalidade', 'LIKE', "%{$request->modalidade}%"],
            ['dispensas.grupo_despesa', 'LIKE', "%{$request->grupo}%"]
        ])->orwhere([
            ['dispensas.identity_id', 'LIKE', "{$identity_id}"],
            ['dispensas.sub_classe_cnae', 'LIKE', "%{$request->pesquisar}%"],
            ['dispensas.modalidade', 'LIKE', "%{$request->modalidade}%"],
            ['dispensas.grupo_despesa', 'LIKE', "%{$request->grupo}%"]
        ])->orwhere([
            ['dispensas.identity_id', 'LIKE', "{$identity_id}"],
            ['dispensas.numero_processo_licitatorio', 'LIKE', "{$request->pesquisar}"],
            ['dispensas.modalidade', 'LIKE', "%{$request->modalidade}%"],
            ['dispensas.grupo_despesa', 'LIKE', "%{$request->grupo}%"]
        ])->orderBy('dispensas.sub_classe_cnae')
            ->get();

        $dispensa = array(
            'dispensa' => $dispensa
        );

        $op = DB::table('townhalls')->where('identity_id', 'like', $identity_id)->select('cidade')->first()->cidade;

        $valorCompra = DB::table('configs')->select('aquis_servicos')->first()->aquis_servicos;
        $valorObra = DB::table('configs')->select('obras_eng_man_vei')->first()->obras_eng_man_vei;

        $pesquisa = array(
            'pesquisa' => $request->pesquisar,
            'dinicial' => $request->dataInicial,
            'dfinal' => $request->dataFinal,
            'modalidade' => $request->modalidade,
            'grupo' => $request->grupo,
            'op' => $op,
            'valorCompra' => $valorCompra,
            'valorObra' => $valorObra
        );

        $pdf = view('pdf.porSubclasse', $dispensa, $pesquisa);

        $mpdf = new \Mpdf\Mpdf([
            'format' => 'A4-P',
            'margin_left' => 8,
            'margin_right' => 8,
            'margin_top' => 23,
            'margin_bottom' => 23,
            'margin_header' => 0,
            'margin_footer' => 15,
        ]);

        $mpdf->WriteHTML($pdf);

        $mpdf->Output(Carbon::now() .'.pdf', \Mpdf\Output\Destination::INLINE);

    }

    public function gerarPdfPorSubclasseResumido(Request $request)
    {
        $identity_id = Auth::user()->identity_id;

        $request->filled('dataInicial') ? $start = Carbon::parse($request->dataInicial)->format('Y-m-d 00:00:00') : $start = Carbon::minValue()->format('Y-m-d 00:00:00');
        $request->filled('dataFinal') ? $end = Carbon::parse($request->dataFinal)->format('Y-m-d 23:59:59') : $end = Carbon::now()->format('Y-m-d 23:59:59');

        $dispensa = DB::table('users')
            ->join('dispensas', 'dispensas.id_user', '=', 'users.id')
            ->havingBetween('dispensas.created_at', [$start, $end])
            ->select(['dispensas.*', 'users.name', 'users.matricula'])
            ->where([
            ['dispensas.identity_id', 'LIKE', "{$identity_id}"],
            ['dispensas.sub_classe_cnae', 'LIKE', "%{$request->pesquisar}%"]
        ])->orderBy('dispensas.sub_classe_cnae')
            ->get();

        $dispensa = array(
            'dispensa' => $dispensa
        );

        $op = DB::table('townhalls')->where('identity_id', 'like', $identity_id)->select('cidade')->first()->cidade;

        $valorCompra = DB::table('configs')->select('aquis_servicos')->first()->aquis_servicos;
        $valorObra = DB::table('configs')->select('obras_eng_man_vei')->first()->obras_eng_man_vei;

        $pesquisa = array(
            'pesquisa' => $request->pesquisar,
            'dinicial' => $request->dataInicial,
            'dfinal' => $request->dataFinal,
            'op' => $op,
            'valorCompra' => $valorCompra,
            'valorObra' => $valorObra
        );

        $pdf = view('pdf.porSubclasseResumido', $dispensa, $pesquisa);

        $mpdf = new \Mpdf\Mpdf([
            'format' => 'A4-P',
            'margin_left' => 8,
            'margin_right' => 8,
            'margin_top' => 23,
            'margin_bottom' => 23,
            'margin_header' => 0,
            'margin_footer' => 15,
        ]);

        $mpdf->WriteHTML($pdf);

        $mpdf->Output(Carbon::now() .'.pdf', \Mpdf\Output\Destination::INLINE);

    }
}
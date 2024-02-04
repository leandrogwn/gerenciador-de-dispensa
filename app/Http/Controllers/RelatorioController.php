<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Dispensa;
use Illuminate\Foundation\Auth\User;

class RelatorioController extends Controller
{
    public function totalDispensa(Request $request)
    {
        $identity_id = Auth::user()->identity_id;

        $request->filled('dataInicial') ? $start = Carbon::parse($request->dataInicial)->format('Y-m-d 00:00:00') : $start = Carbon::minValue()->format('Y-m-d 00:00:00');
        $request->filled('dataFinal') ? $end = Carbon::parse($request->dataFinal)->format('Y-m-d 23:59:59') : $end = Carbon::now()->format('Y-m-d 23:59:59');

        $config = DB::table('configs')->first();

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
        ]);

        $totalSoma = $dispensa->sum('valor');

        $dispPag = $dispensa->paginate($config->pag_rel_total);

        return view('dispensa.relatorioTotalDispensa')->with('dispensa', $dispPag)->with('totalSoma', $totalSoma);

    }

    public function porSubclasse(Request $request)
    {
        $identity_id = Auth::user()->identity_id;

        $request->filled('dataInicial') ? $start = Carbon::parse($request->dataInicial)->format('Y-m-d 00:00:00') : $start = Carbon::minValue()->format('Y-m-d 00:00:00');
        $request->filled('dataFinal') ? $end = Carbon::parse($request->dataFinal)->format('Y-m-d 23:59:59') : $end = Carbon::now()->format('Y-m-d 23:59:59');
        
        $config = DB::table('configs')->first();

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
        ])->orderBy('dispensas.sub_classe_cnae');
        
        $totalSoma = $dispensa->sum('valor');

        $dispPag = $dispensa->paginate($config->pag_rel_subs);

        return view('dispensa.relatorioPorSubclasse')->with('dispensa', $dispPag)->with('totalSoma', $totalSoma);

    }

    public function porSubclasseResumido(Request $request)
    {
        $identity_id = Auth::user()->identity_id;

        $request->filled('dataInicial') ? $start = Carbon::parse($request->dataInicial)->format('Y-m-d 00:00:00') : $start = Carbon::minValue()->format('Y-m-d 00:00:00');
        $request->filled('dataFinal') ? $end = Carbon::parse($request->dataFinal)->format('Y-m-d 23:59:59') : $end = Carbon::now()->format('Y-m-d 23:59:59');
        
        $config = DB::table('configs')->first();

        $dispensa = DB::table('users')
            ->join('dispensas', 'dispensas.id_user', '=', 'users.id')
            ->havingBetween('dispensas.created_at', [$start, $end])
            ->select(['dispensas.*', 'users.name', 'users.matricula'])
            ->where([
            ['dispensas.identity_id', 'LIKE', "{$identity_id}"],
            ['dispensas.discriminacao', 'LIKE', "%{$request->pesquisar}%"]
        ])->orwhere([
            ['dispensas.identity_id', 'LIKE', "{$identity_id}"],
            ['dispensas.sub_classe_cnae', 'LIKE', "%{$request->pesquisar}%"]
        ])->orwhere([
            ['dispensas.identity_id', 'LIKE', "{$identity_id}"],
            ['dispensas.numero_processo_licitatorio', 'LIKE', "{$request->pesquisar}"]
        ])->orderBy('dispensas.sub_classe_cnae');

        $totalSoma = $dispensa->sum('valor');

        $dispPag = $dispensa->paginate($config->pag_rel_sub_res);

        return view('dispensa.relatorioPorSubclasseResumido')->with('dispensa', $dispPag)->with('config', $config)->with('totalSoma', $totalSoma);

    }
}

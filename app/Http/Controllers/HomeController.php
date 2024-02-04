<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Townhall;
use App\Models\Dispensa;
use Illuminate\Foundation\Auth\User;
use Carbon\Carbon;
use DateTimeZone;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $identity_id = Auth::user()->identity_id;

        $dataAtual = Carbon::now()->format('d-m-Y');

        $dataInicio = Carbon::now()->firstOfYear()->format('d-m-Y');

        $op = Townhall::where('identity_id', $identity_id)->first();

        $qtdUsuario = User::where('identity_id', $identity_id)->select(DB::raw('count(id) as qtd'))->first()->qtd;

        $qtdDispensa = Dispensa::where('identity_id', $identity_id)->select(DB::raw('count(id) as qtd'))->first()->qtd;

        $valorGasto = Dispensa::where('identity_id', $identity_id)->select(DB::raw('sum(valor) as soma'))->first()->soma;

        $ultimaAtualizacaoDispensa = Dispensa::where('identity_id', $identity_id)->select(DB::raw('max(updated_at) as data'))->first()->data;

        $rankingGastoCnae = Dispensa::where('identity_id', $identity_id)->select('sub_classe_cnae', DB::raw('sum(valor) as soma'), DB::raw('count(sub_classe_cnae) as qtd'))->orderByDesc('soma')->groupBy('sub_classe_cnae')->limit(4)->get();

        $rankingGastoProcesso = Dispensa::where('identity_id', $identity_id)->select('numero_processo_licitatorio', 'discriminacao', 'valor')->orderByDesc('valor')->limit(4)->get();

        $gastoPorModalidade = Dispensa::where('identity_id', $identity_id)->select('modalidade', DB::raw('sum(valor) as soma'), DB::raw('count(modalidade) as qtdModalidade'))->orderByDesc('soma')->groupBy('modalidade')->get();

        $gastoPorGrupo = Dispensa::where('identity_id', $identity_id)->select('grupo_despesa', DB::raw('sum(valor) as soma'), DB::raw('count(grupo_despesa) as qtdDispensa'))->orderByDesc('soma')->groupBy('grupo_despesa')->get();

        $totalizador = array(
            'dataInicio' => $dataInicio,
            'dataAtual' => $dataAtual,
            'ultimaAtualizacaoDispensa' => $ultimaAtualizacaoDispensa,
            'qtdUsuario' => $qtdUsuario,
            'qtdDispensa' => $qtdDispensa,
            'valorGasto' => $valorGasto
        );

        $jsonPorModalidade = '';
        foreach ($gastoPorModalidade as $item) {
            $jsonPorModalidade .= '{value: ' . $item->soma . ', name: `' . $item->modalidade . '`},';
        }
        ;

        $jsonPorGrupo = '';
        foreach ($gastoPorGrupo as $item) {
            $jsonPorGrupo .= '{value: ' . $item->soma . ', name: `' . $item->grupo_despesa . '`},';
        }
        ;
        //dd($totalizador);

        return view('home')
            ->with('op', $op)
            ->with($totalizador)
            ->with('rankingGastoProcesso', $rankingGastoProcesso)
            ->with('rankingGastoCnae', $rankingGastoCnae)
            ->with('jsonPorModalidade', $jsonPorModalidade)
            ->with('gastoPorModalidade', $gastoPorModalidade)
            ->with('jsonPorGrupo', $jsonPorGrupo)
            ->with('gastoPorGrupo', $gastoPorGrupo);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Dispensa;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use App\Models\Log;

class DispensaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $identity_id = Auth::user()->identity_id;

        $config = DB::table('configs')->first();

        $dispensa = DB::table('users')
            ->join('dispensas', 'dispensas.id_user', '=', 'users.id')
            ->where([['dispensas.identity_id', 'LIKE', "{$identity_id}"]])
            ->select(['dispensas.*', 'users.name', 'users.matricula'])
            ->orderByDesc('dispensas.id')
            ->paginate($config->pag_rel_total);

        return view('dispensa.dispensa')->with('dispensa', $dispensa);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();

        return view('dispensa.register')->with('user', $user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'modalidade' => ['required', 'string', 'max:255'],
            'discriminacao' => ['required', 'string', 'max:255'],
            'sub_classe_cnae' => ['required', 'string'],
            'grupo_despesa' => ['required', 'string'],
            'valor' => ['required'],
            'numero_dispensa' => ['required', 'string', 'max:255'],
            'numero_processo_licitatorio' => ['required', 'string', 'max:255'],
        ]);

        $stringValor = $request['valor'];
        $stringNotRS = str_replace('R$ ', '', $stringValor);
        $stringNotPonto = str_replace('.', '', $stringNotRS);
        $valor = str_replace(',', '.', $stringNotPonto);

        $stringSubClasse = explode('·', $request['sub_classe_cnae'], 2);
        $subclasse = $stringSubClasse[0];
        $atividade = $stringSubClasse[1];

        Dispensa::create([
            'identity_id' => $user->identity_id,
            'id_user' => $user->id,
            'modalidade' => $request['modalidade'],
            'discriminacao' => $request['discriminacao'],
            'sub_classe_cnae' => $subclasse,
            //'sub_classe_cnae' => md5('cnae'),
            'atividade' => $atividade,
            'grupo_despesa' => $request['grupo_despesa'],
            'valor' => $valor,
            'numero_dispensa' => $request['numero_dispensa'],
            'numero_processo_licitatorio' => $request['numero_processo_licitatorio'],
        ]);

        return redirect()->action('App\Http\Controllers\DispensaController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
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
        ])->orderByDesc('dispensas.id')
            ->paginate($config->pag_rel_total);

        return view('dispensa.dispensa')->with('dispensa', $dispensa);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::user();

        $dispensa = Dispensa::find($id);

        return view('dispensa.edit')->with('user', $user)->with('dispensa', $dispensa);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();

        $this->validate($request, [
            'modalidade' => ['required', 'string', 'max:255'],
            'discriminacao' => ['required', 'string', 'max:255'],
            'sub_classe_cnae' => ['required', 'string'],
            'grupo_despesa' => ['required', 'string'],
            'valor' => ['required'],
            'numero_dispensa' => ['string', 'max:255', 'required'],
            'numero_processo_licitatorio' => ['required', 'string', 'max:255'],
        ]);

        $stringValor = $request['valor'];
        $stringNotRS = str_replace('R$ ', '', $stringValor);
        $stringNotPonto = str_replace('.', '', $stringNotRS);
        $valor = str_replace(',', '.', $stringNotPonto);

        $stringSubClasse = explode('·', $request['sub_classe_cnae'], 2);
        $subclasse = trim($stringSubClasse[0]);
        $atividade = $stringSubClasse[1];

        $dispensa = Dispensa::find($id);

        Dispensa::where('id', $id)->update([
            'modalidade' => $request['modalidade'],
            'discriminacao' => $request['discriminacao'],
            'sub_classe_cnae' => $subclasse,
            'atividade' => $atividade,
            'grupo_despesa' => $request['grupo_despesa'],
            'valor' => $valor,
            'numero_dispensa' => $request['numero_dispensa'],
            'numero_processo_licitatorio' => $request['numero_processo_licitatorio'],
        ]);

        Log::create([
            'identity_id' => $user->identity_id,
            'id_user' => $user->id,
            'produto' => 'Gerenciador de Dispensa',
            'tabela' => 'Dispensa',
            'processo' => 'Alteração',
            'alteracao' => 'De - Id: ' . $id .
            ' | Modalidade: ' . $dispensa->modalidade .
            ' | Discriminacao: ' . $dispensa->discriminacao .
            ' | Subclasse cnae: ' . $dispensa->sub_classe_cnae .
            ' | Atividade: ' . $dispensa->atividade .
            ' | Grupo despesa: ' . $dispensa->grupo_despesa .
            ' | Valor: ' . 'R$ ' . number_format($dispensa->valor, 2, ',', '.') .
            ' | Numero dispensa: ' . $dispensa->numero_dispensa .
            ' | Numero processo licitatorio: ' . $dispensa->numero_processo_licitatorio . '<br>' .

            ' Para - Id: ' . $id .
            ' | Modalidade: ' . $request['modalidade'] .
            ' | Discriminacao: ' . $request['discriminacao'] .
            ' | Subclasse cnae: ' . $subclasse .
            ' | Atividade: ' . $atividade .
            ' | Grupo despesa: ' . $request['grupo_despesa'] .
            ' | Valor: ' . $request['valor'] .
            ' | Numero dispensa: ' . $request['numero_dispensa'] .
            ' | Numero processo licitatorio: ' . $request['numero_processo_licitatorio']
        ]);

        return redirect()->action('App\Http\Controllers\DispensaController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user();

        $dispensa = Dispensa::find($id);

        Log::create([
            'identity_id' => $user->identity_id,
            'id_user' => $user->id,
            'produto' => 'Gerenciador de Dispensa',
            'tabela' => 'Dispensa',
            'processo' => 'Exclusão',
            'alteracao' => 'Id: ' . $id .
            ' | Modalidade: ' . $dispensa->modalidade .
            ' | Discriminacao: ' . $dispensa->discriminacao .
            ' | Subclasse cnae: ' . $dispensa->sub_classe_cnae .
            ' | Atividade: ' . $dispensa->atividade .
            ' | Grupo despesa: ' . $dispensa->grupo_despesa .
            ' | Valor: ' . 'R$ ' . number_format($dispensa->valor, 2, ',', '.') .
            ' | Numero dispensa: ' . $dispensa->numero_dispensa .
            ' | Numero processo licitatorio: ' . $dispensa->numero_processo_licitatorio
        ]);

        Dispensa::find($id)->delete();

        return redirect()->action('App\Http\Controllers\DispensaController@index')->with('mensagem', 'sucess');
    }
}

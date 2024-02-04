<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class CnaeController extends Controller
{
    public function create()
    {

        if (empty(DB::table('cnaes')->select('versao')->first()->versao)) {
            $versao = 0;
        }
        else {
            $versao = DB::table('cnaes')->select('versao')->first()->versao;
        }
        ;

        return view('config.cnae')->with('versao', $versao);

    }

    public function update(Request $id)
    {
        DB::table('cnaes')->truncate();

        set_time_limit(20000);

        $request = Http::get('https://servicodados.ibge.gov.br/api/v2/cnae/secoes');
        $sessions = json_decode($request->body(), false);
        foreach ($sessions as $session) {
            $request = Http::get('https://servicodados.ibge.gov.br/api/v2/cnae/secoes/' . $session->id . '/divisoes');
            $divisions = json_decode($request->body(), false);

            foreach ($divisions as $division):
                $request = Http::get('https://servicodados.ibge.gov.br/api/v2/cnae/divisoes/' . $division->id . '/grupos');
                $groups = json_decode($request->body(), false);

                foreach ($groups as $group):
                    $request = Http::get('https://servicodados.ibge.gov.br/api/v2/cnae/grupos/' . $group->id . '/classes');
                    $classes = json_decode($request->body(), false);

                    foreach ($classes as $class):

                        $request = Http::get('https://servicodados.ibge.gov.br/api/v2/cnae/classes/' . $class->id . '/subclasses');
                        $subclasses = json_decode($request->body(), false);

                        foreach ($subclasses as $subclass):

                            $identification = substr_replace($subclass->id, '-', 4, 0);
                            $identification = substr_replace($identification, '/', 6, 0);

                            $obs0 = "";
                            $obs1 = "";
                            $obs2 = "";

                            if (!empty($subclass->observacoes[0])) {
                                $obs0 = $subclass->observacoes[0];
                            }

                            if (!empty($subclass->observacoes[1])) {

                                if (str_contains($subclass->observacoes[1], "Esta subclasse compreende ainda")) {
                                    $obs1 = $subclass->observacoes[1];
                                }
                                else if (str_contains($subclass->observacoes[1], "Esta subclasse NÃO compreende")) {
                                    $obs2 = $subclass->observacoes[1];
                                }
                            }

                            if (!empty($subclass->observacoes[2])) {
                                $obs2 = $subclass->observacoes[2];
                            }

                            DB::table('cnaes')->insert(
                            [
                                'versao' => $id->versao,
                                'subclasse' => $identification,
                                'atividade' => $subclass->atividades[0],
                                'compreende' => $obs0,
                                'compreende_ainda' => $obs1,
                                'nao_compreende' => $obs2,
                            ]
                            );

                        endforeach;
                    endforeach;
                endforeach;
            endforeach;
        }

        $versao = DB::table('cnaes')->select('versao')->first()->versao;

        return redirect()->action('App\Http\Controllers\CnaeController@create')->with('versao', $versao)->with('update', $versao);
    }

    public function filter(Request $request)
    {
        $subclasse = DB::table('cnaes')->select('*')->where('atividade', 'LIKE', '%' . $request->atividade . '%')->get();
        return $subclasse;
    }
}
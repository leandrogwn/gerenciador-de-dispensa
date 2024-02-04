<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Config;
use Illuminate\Support\Facades\DB;

class ConfigController extends Controller
{
    public function carregarConfig()
    {
        $config = DB::table('configs')->get();
        return view('config.config')->with('config', $config);
    }

    public function updateConfig(Request $request)
    {
        $this->validate($request, [
            'obras_eng_man_vei' => ['required', 'max:13'],
            'aquis_servicos' => ['required', 'max:13'],
            'pag_rel_subs' => ['required', 'max:5'],
            'pag_rel_sub_res' => ['required', 'max:5'],
            'pag_rel_total' => ['required', 'max:5'],
        ]);

        function convValor($vl)
        {
            $stringValor = $vl;
            $stringNotRS = str_replace('R$ ', '', $stringValor);
            $stringNotPonto = str_replace('.', '', $stringNotRS);
            $valor = str_replace(',', '.', $stringNotPonto);
            return $valor;
        }

        Config::where('id', '>', 0)->update([
            'obras_eng_man_vei' => convValor($request['obras_eng_man_vei']),
            'aquis_servicos' => convValor($request['aquis_servicos']),
            'pag_rel_subs' => $request['pag_rel_subs'],
            'pag_rel_sub_res' => $request['pag_rel_sub_res'],
            'pag_rel_total' => $request['pag_rel_total'],
        ]);
        return redirect()->action('App\Http\Controllers\ConfigController@carregarConfig')->with('update', 'ok');
    }
}

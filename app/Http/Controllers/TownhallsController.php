<?php

namespace App\Http\Controllers;

use App\Models\Townhall;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Validation\Rule;


class TownhallsController extends Controller
{
    public function listarTudo(Request $request)
    {
        $id = Auth::user()->id;
        $townhall = Townhall::where([
            ['id', '<>', "{$id}"],
            ['cidade', 'LIKE', "%{$request->pesquisar}%"]
        ])->paginate(10);

        return view('townhall.townhall')->with('townhall', $townhall);
    }

    public function listar()
    {
        $search = Request::input('pesquisar');

        $townhall = Townhall::where('cidade', $search)->get();

        return view('townhall.townhall')->with('townhall', $townhall);
    }
    public function novaPrefeitura()
    {
        return view('townhall.register');
    }

    public function salvarPrefeitura(Request $data)
    {
        $data->validate([
            'cidade' => ['required', 'string', 'max:255'],
            'fone' => ['required', 'string', 'min:14', 'max:15'],
            'responsavel' => ['required', 'string', 'max:255'],
            'matricula' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $identity_id = md5($data['email']);
        $cidade = $data['cidade'];
        $fone = $data["fone"];
        $responsavel = $data["responsavel"];
        $matricula = $data["matricula"];
        $email = $data['email'];
        $password = Hash::make($data['password']);
        $id_origem = Auth::id();


        Townhall::create([
            'identity_id' => $identity_id,
            'cidade' => $cidade,
            'fone' => $fone,
            'responsavel' => $responsavel,
            'matricula' => $matricula,
            'email' => $email,
            'password' => $password,
        ]);

        User::create([
            'identity_id' => $identity_id,
            'name' => $responsavel,
            'matricula' => $matricula,
            'perfil' => 'Administrador',
            'email' => $email,
            'password' => $password,
            'id_origem' => $id_origem,
            'admin' => false,
        ]);


        return redirect()->action('App\Http\Controllers\TownhallsController@listarTudo');
    }

    public function excluirPrefeitura($id)
    {
        Townhall::find($id)->delete();

        return back();

    }

    public function editarPrefeitura($id)
    {

        $townhall = Townhall::find($id);

        return view('townhall.edit')->with('townhall', $townhall);
    }

    public function updatePrefeitura(Request $request, $id)
    {
        $this->validate($request, [
            'cidade' => ['required', 'string', 'max:255'],
            'fone' => ['required', 'string', 'min:14', 'max:15'],
            'responsavel' => ['required', 'string', 'max:255'],
            'matricula' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('townhalls')->ignore($id)],
        ]);

        Townhall::where('id', $id)->update([
            'cidade' => $request['cidade'],
            'fone' => $request['fone'],
            'responsavel' => $request['responsavel'],
            'matricula' => $request['matricula'],
            'email' => $request['email'],
        ]);

        return redirect()->action('App\Http\Controllers\TownhallsController@listarTudo');
    }




}

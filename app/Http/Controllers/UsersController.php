<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\Log;

class UsersController extends Controller
{

    public function listarTudo(Request $request)
    {
        $id = Auth::user()->id;
        $identity_id = Auth::user()->identity_id;

        $users = User::where([
            ['id', '<>', "{$id}"],
            ['identity_id', 'LIKE', "{$identity_id}"],
            ['name', 'LIKE', "%{$request->pesquisar}%"]
        ])->orwhere([
            ['id', '<>', "{$id}"],
            ['identity_id', 'LIKE', "{$identity_id}"],
            ['matricula', 'LIKE', "{$request->pesquisar}"]
        ])->paginate(10);

        return view('users')->with('users', $users);
    }

    public function listar()
    {
        $search = Request::input('pesquisar');

        $users = User::where('name', $search)->get();

        return view('users')->with('users', $users);
    }
    public function novoUsuario()
    {
        return view('auth.register');
    }

    public function salvarUsuario(Request $data)
    {
        $data->validate([
            'name' => ['required', 'string', 'max:255'],
            'matricula' => ['required', 'string', 'max:255', Rule::unique('users')->where(fn($query) => $query->where('identity_id', Auth::user()->identity_id))],
            'perfil' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create([
            'identity_id' => Auth::user()->identity_id,
            'name' => $data['name'],
            'matricula' => $data["matricula"],
            'perfil' => $data["perfil"],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'id_origem' => Auth::user()->id,
            'admin' => false,
        ]);

        return redirect()->action('App\Http\Controllers\UsersController@listarTudo');
    }

    public function excluirUsuario($id)
    {
        $user_loged = Auth::user();

        $user = User::find($id);

        Log::create([
            'identity_id' => $user_loged->identity_id,
            'id_user' => $user_loged->id,
            'produto' => 'Gerenciador de Dispensa',
            'tabela' => 'Usuário',
            'processo' => 'Exclusão',
            'alteracao' => 'Id: ' . $id .
            ' | Nome: ' . $user->name .
            ' | Matricula: ' . $user->matricula .
            ' | Perfil: ' . $user->perfil .
            ' | E-mail: ' . $user->email .
            ' | Id Origem: ' . $user->id_origem
        ]);

        User::find($id)->delete();

        return redirect()->action('App\Http\Controllers\UsersController@listarTudo')->with('mensagem', 'sucess');
    }

    public function editarUsuario($id)
    {

        $user = User::find($id);

        return view('auth.edit')->with('user', $user);
    }

    public function updateUsuario(Request $request, $id)
    {
        $user_loged = Auth::user();

        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'matricula' => ['required', 'string', 'max:255', Rule::unique('users')->where(fn($query) => $query->where('identity_id', Auth::user()->identity_id))->ignore($id)],
            'perfil' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($id)],
        ]);

        $user = User::find($id);

        User::where('id', $id)->update([
            'name' => $request['name'],
            'matricula' => $request['matricula'],
            'perfil' => $request['perfil'],
            'email' => $request['email'],
        ]);

        Log::create([
            'identity_id' => $user_loged->identity_id,
            'id_user' => $user_loged->id,
            'produto' => 'Gerenciador de Dispensa',
            'tabela' => 'Usuário',
            'processo' => 'Alteração',
            'alteracao' => 'De - Id: ' . $id .
            ' | Nome: ' . $user->name .
            ' | Matricula: ' . $user->matricula .
            ' | Perfil: ' . $user->perfil .
            ' | E-mail: ' . $user->email . '<br>' .

            ' Para - Id: ' . $id .
            ' | Nome: ' . $request['name'] .
            ' | Matricula: ' . $request['matricula'] .
            ' | Perfil: ' . $request['perfil'] .
            ' | E-mail: ' . $request['email']
        ]);

        return redirect()->action('App\Http\Controllers\UsersController@listarTudo');
    }

    public function minhaConta()
    {

        $user = User::find(Auth::user()->id);

        return view('auth.editAccount')->with('user', $user);
    }

    public function updateConta(Request $request, $id)
    {
        $user_loged = Auth::user();

        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'matricula' => ['required', 'string', 'max:255', Rule::unique('users')->where(fn($query) => $query->where('identity_id', Auth::user()->identity_id))->ignore($id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($id)],
        ]);

        $user = User::find($id);

        User::where('id', $id)->update([
            'name' => $request['name'],
            'matricula' => $request['matricula'],
            'email' => $request['email'],
        ]);

        Log::create([
            'identity_id' => $user_loged->identity_id,
            'id_user' => $user_loged->id,
            'produto' => 'Gerenciador de Dispensa',
            'tabela' => 'Usuário',
            'processo' => 'Alteração na conta',
            'alteracao' => 'De - Id: ' . $id .
            ' | Nome: ' . $user->name .
            ' | Matricula: ' . $user->matricula .
            ' | E-mail: ' . $user->email . '<br>' .

            ' Para - Id: ' . $id .
            ' | Nome: ' . $request['name'] .
            ' | Matricula: ' . $request['matricula'] .
            ' | E-mail: ' . $request['email']
        ]);

        return redirect()->action('App\Http\Controllers\UsersController@minhaConta')->with('update', 'ok');
    }

    public function updateSenha(Request $request, $id)
    {
        $user_loged = Auth::user();

        $this->validate($request, [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'current_password' => ['required', function ($attribute, $value, $fail) {
            if (!Hash::check($value, Auth::user()->password)) {
                return $fail(__('A senha atual esta incorreta.'));
            }
        }]
        ]);

        User::where('id', $id)->update([
            'password' => Hash::make($request['password']),
        ]);

        Log::create([
            'identity_id' => $user_loged->identity_id,
            'id_user' => $user_loged->id,
            'produto' => 'Gerenciador de Dispensa',
            'tabela' => 'Usuário',
            'processo' => 'Alteração de senha',
            'alteracao' => 'Privado ao usuário'
        ]);

        return redirect()->action('App\Http\Controllers\Auth\LoginController@logout');
    }

}

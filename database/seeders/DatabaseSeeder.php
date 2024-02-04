<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Config;
use App\Models\Townhall;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        Config::create([
            'obras_eng_man_vei' => '108040.82',
            'aquis_servicos' => '54020.41',
            'pag_rel_subs' => '10',
            'pag_rel_sub_res' => '15',
            'pag_rel_total' => '10',
        ]);

        $email = 'leandro.gwn@gmail.com';
        $identity_id = md5($email);
        $password = Hash::make('K1616@Seq01K');
        $id_origem = '1';
        $responsavel = 'Leandro Gonçalves';
        $matricula = '123456';

        Townhall::create([
            'identity_id' => $identity_id,
            'cidade' => 'Conta de administrador',
            'fone' => '(45) 99940-6202',
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
            'admin' => true,
        ]);

    }
}

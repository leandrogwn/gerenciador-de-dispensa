<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dispensa extends Model
{
    use HasFactory;

    protected $fillable = [
        'identity_id',
        'id_user',
        'modalidade',
        'discriminacao',
        'sub_classe_cnae',
        'atividade',
        'grupo_despesa',
        'valor',
        'numero_dispensa',
        'numero_processo_licitatorio',
    ];

}

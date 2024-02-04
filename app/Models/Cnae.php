<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cnae extends Model
{
    use HasFactory;
    protected $fillable = [
        'versao',
        'subclasse',
        'atividade',
        'compreende',
        'compreende_ainda',
        'nao_compreende'
    ];

}

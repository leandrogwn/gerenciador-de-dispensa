<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;

    protected $fillable = [
        'obras_eng_man_vei',
        'aquis_servicos',
        'pag_rel_sub',
        'pag_rel_sub_res',
        'pag_rel_total'
    ];

}

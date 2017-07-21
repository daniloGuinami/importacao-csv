<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $fillable = [
        'descricao',
        'data_transacao'
    ];

    public function funcionarios()
    {
        return $this->hasMany('App\Funcionarios');
    }
}

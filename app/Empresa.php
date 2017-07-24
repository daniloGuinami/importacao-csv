<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $fillable = [
        'id_empresa',
        'data_transacao',
        'status'
    ];

    public function funcionarios()
    {
        return $this->hasMany('App\Funcionarios');
    }
}

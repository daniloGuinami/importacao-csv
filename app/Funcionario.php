<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    protected $fillable = [
        'empresa_id',
        'nome',
        'data_transacao'
    ];

    public function empresa()
    {
        return $this->belongsTo('App\Empresa');
    }
}

<?php

namespace App\Repository;

use App\Empresa;
use App\User;

class EmpresaRepository
{
    private $empresa;

    public function __construct(Empresa $empresa)
    {
        $this->empresa = $empresa;
    }

    public function getAll()
    {
        return $this->empresa->all();
    }

    public function getIdEmpresa($id)
    {
        return $this->empresa->where('id_empresa', $id)->value('id_empresa');
    }

    public function atualizarStatus($id)
    {
        return $this->empresa->where('id_empresa', $id)->update([
            'status' => 2
        ]);
    }

    public function atualizarDataTransacao($dadosEmpresa)
    {
        return $this->empresa->where('id_empresa', $dadosEmpresa['id_empresa'])->update([
            'data_transacao' => $dadosEmpresa['data_transacao']
        ]);
    }

    public function create(array $data)
    {
        return $this->empresa->create($data)->id_empresa;
    }
}
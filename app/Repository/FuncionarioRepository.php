<?php

namespace App\Repository;

use App\Funcionario;

class FuncionarioRepository
{
    private $funcionario;

    public function __construct(Funcionario $funcionario)
    {
        $this->funcionario = $funcionario;
    }

    public function getIdFuncionario($id)
    {
        return $this->funcionario->where('id_funcionario', $id)->value('id_funcionario');
    }

    public function atualizarStatus($dadosFuncionario)
    {
        return $this->funcionario->where('id_funcionario', $dadosFuncionario['id_funcionario'])->update([
            'status' => 2
        ]);
    }

    public function create(array $data)
    {
        return $this->funcionario->create($data);
    }

    public function getAll()
    {
        return $this->funcionario->all();
    }
}
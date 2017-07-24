<?php

namespace App\Services;

use App\Repository\FuncionarioRepository;

class FuncionarioService
{
    private $funcionarioRepositoy;

    public function __construct(FuncionarioRepository $funcionarioRepositoy)
    {
        $this->funcionarioRepositoy = $funcionarioRepositoy;
    }

    public function getIdFuncionario($id)
    {
        return $this->funcionarioRepositoy->getIdFuncionario($id);
    }

    /**
     * @param $dadosFuncionario
     * @return bool
     */
    public function atualizarStatus($dadosFuncionario)
    {
        if (!$this->getIdFuncionario($dadosFuncionario['id_funcionario'])) {
            (new LogService())
                ->setId($dadosFuncionario['id_funcionario'])
                ->setDescricao('Este funcionário não existe no banco de dados!')
                ->setTipo('LogAtualizacao')
                ->gerarLog();

            return false;
        } else {
            return $this->funcionarioRepositoy->atualizarStatus($dadosFuncionario);
        }
    }

    public function inserir($dadosFuncionario)
    {
        $this->funcionarioRepositoy->create($dadosFuncionario);
    }

    public function getAll()
    {
        return $this->funcionarioRepositoy->getAll();
    }
}
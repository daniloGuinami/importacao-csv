<?php

namespace App\Services;

use App\Repository\EmpresaRepository;

class EmpresaService
{
    private $empresaRepository;

    public function __construct(EmpresaRepository $empresaRepository)
    {
        $this->empresaRepository = $empresaRepository;
    }

    //todo alterar tabela empreas, removendo alguns campos e inserindo outros,
    public function inserir($dados)
    {
        if (count($dados) > 0) {
            foreach ($dados as $item) {

            }
        }

        return true;
    }
}
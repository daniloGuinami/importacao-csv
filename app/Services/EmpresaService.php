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

    public function getIdEmpresa($id)
    {
        return $this->empresaRepository->getIdEmpresa($id);
    }

    public function atualizarStatus($id)
    {
        if (!$this->getIdEmpresa($id)) {
            (new LogService())
                ->setId($id)
                ->setDescricao('Este empresa não existe no banco de dados!')
                ->setTipo('LogAtualizacao')
                ->gerarLog();

            return false;
        } else {
            return $this->empresaRepository->atualizarStatus($id);
        }
    }

    public function atualizarDataTransacao($dadosEmpresa)
    {
        return $this->empresaRepository->atualizarDataTransacao($dadosEmpresa);
    }

    public function inserir($dadosEmprsea)
    {
        return $this->empresaRepository->create($dadosEmprsea);
    }
}
<?php

namespace App\Http\Controllers;

use App\Repository\EmpresaRepository;

class EmpresaController extends Controller
{
    private $empresaRepository;

    public function __construct(EmpresaRepository $empresaRepository)
    {
        $this->empresaRepository = $empresaRepository;
    }

    public function lista()
    {
        return $this->empresaRepository->findAll();
    }

    public function salvar($dados)
    {
        return $this->empresaRepository->create($dados);
    }
}

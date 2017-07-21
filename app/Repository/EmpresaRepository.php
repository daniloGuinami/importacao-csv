<?php
namespace App\Repository;
use App\Empresa;

class EmpresaRepository
{
    private $empresa;

    public function __construct(Empresa $empresa)
    {
        $this->empresa = $empresa;
    }

    public function findAll()
    {
        return $this->empresa->all();
    }

    public function findById($id)
    {
        return $this->empresa->find($id);
    }

    public function create(array $data)
    {
        return $this->empresa->create($data);
    }
}
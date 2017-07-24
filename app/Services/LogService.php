<?php

namespace App\Services;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class LogService
{
    protected $id;
    protected $descricao;
    protected $tipo;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }

    public function gerarLog()
    {
        $orderLog = new Logger('importacao');
        $orderLog->pushHandler(new StreamHandler(storage_path('logs/importacao.log')), Logger::INFO);
        $orderLog->info($this->getTipo(), $this->montaDadosLog());
    }

    private function montaDadosLog()
    {
        return [
            'id' => ($this->getId()) ?: '',
            'descricao' => $this->getDescricao()
        ];
    }
}
<?php

namespace App\Console\Commands;

use App\Services\EmpresaService;
use App\Services\FuncionarioService;
use Illuminate\Console\Command;

class CsvList extends Command
{
    /**
     * Nome e assinatura do comando no console.
     *
     * @var string
     */
    protected $signature = 'csv:list {entidade}';

    /**
     * A descrição do comando no console.
     *
     * @var string
     */
    protected $description = 'Consulta os dados de uma determinada entidade';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Instruções que serão executadas no console.
     *
     * @return mixed
     */
    public function handle(EmpresaService $empresaService, FuncionarioService $funcionarioService)
    {
        $entidade = $this->argument('entidade');

        if ($entidade == 'empresas') {
            echo $empresaService->getAll()->toJson();
            return false;
        }

        if ($entidade == 'funcionarios') {
            echo $funcionarioService->getAll()->toJson();
            return false;
        }

        return false;
    }
}

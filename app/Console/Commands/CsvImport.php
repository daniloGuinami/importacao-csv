<?php

namespace App\Console\Commands;

use App\Services\ImportacaoServices;
use Illuminate\Console\Command;

class CsvImport extends Command
{
    /**
     * Nome e assinatura do comando no console.
     *
     * @var string
     */
    protected $signature = 'csv:import {nomeArquivo}';

    /**
     * A descrição do comando no console.
     *
     * @var string
     */
    protected $description = 'Realiza importação de informações de arquivo CSV';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Instruções que serão executadas no console.
     *
     * @return mixed
     */
    public function handle(ImportacaoServices $importacaoServices)
    {
        $nomeArquivo = $this->argument('nomeArquivo');
        $importacaoServices
            ->setNomeArquivo($nomeArquivo)
            ->realizarImportacao();
        $importacaoServices->moverArquivos();

        echo 'Arquivos importados com sucesso!';
    }
}
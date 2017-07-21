<?php

namespace App\Console\Commands;

use App\Services\ImportacaoServices;
use Illuminate\Console\Command;

class CsvImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'csv:import {nomeArquivo}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Realiza importação de informações de arquivo CSV';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(ImportacaoServices $importacaoServices)
    {
        $nomeArquivo = $this->argument('nomeArquivo');
        $dados = $importacaoServices->validarDados($nomeArquivo);
//        $path = "C:\importacaoCsv\storage\app\arquivos-a-processar\\" . $arquivo;
//        $novoPath = "C:\importacaoCsv\storage\app\arquivos-processados\\" . $arquivo;

        // pega informações do array
//        $teste = $this->csvToArray($path);



//        $abc = $this->repository->create($teste);
//        $abc = $this->repository->all();
        // move os arquivos de lugar
        //        Storage::disk('local')->put('arquivo1.csv', 'Contents');
//        $a = Storage::exists('arquivos-a-processar\arquivo1.csv');
//        Storage::move('arquivos-a-processar\arquivo1.csv', 'arquivos-processados\arquivo1.csv');
//
//        dd($abc);
    }

    function csvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
            {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }

        return $data;
    }
}

<?php

namespace App\Services;

use App\Services\EmpresaService;
use Illuminate\Support\Facades\Config;

class ImportacaoServices
{
    private $empresaService;

    public function __construct(EmpresaService $empresaService)
    {
        $this->empresaService = $empresaService;
    }

    public function validarDados($nomeArquivo)
    {
        $dadosParaImportacao = $this->validarDadosImportacao([
            'dados' => $this->csvToArray($nomeArquivo)
        ]);

        $dadosPersistencia = $this->realizarValidacoesImportacao($dadosParaImportacao);

        $retorno = $this->empresaService->inserir($dadosPersistencia['insercao']['empresa']);


//        $teste = [
//            'descricao' => 'teste de empresa',
//            'data_transacao' => date('Y-m-d')
//        ];
//
//        $retorno = $this->empresRepository->create($teste);

//        $retorno = $this->empresaService->findById(2);

        dd($retorno);

//        $path = "C:\importacaoCsv\storage\app\arquivos-a-processar\\" . $arquivo;
//        $novoPath = "C:\importacaoCsv\storage\app\arquivos-processados\\" . $arquivo;

        // pega informações do array
//        $teste = $this->csvToArray($nomeArquivo);


//        $abc = $this->repository->create($teste);
//        $abc = $this->repository->all();
        // move os arquivos de lugar
        //        Storage::disk('local')->put('arquivo1.csv', 'Contents');
//        $a = Storage::exists('arquivos-a-processar\arquivo1.csv');
//        Storage::move('arquivos-a-processar\arquivo1.csv', 'arquivos-processados\arquivo1.csv');

//        dd($abc);

    }

    private function csvToArray($nomeArquivo = '', $delimiter = ',')
    {
        $arquivo = Config::get('constants.paths.atual') . $nomeArquivo;

        if (!file_exists($arquivo) || !is_readable($arquivo)) {
            echo 'Arquivo inexistente!';
            return false;
        }

        $header = null;
        $data = [];

        if (($handle = fopen($arquivo, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                $data[] = $row;
            }

            fclose($handle);
        }

        return $data;
    }

    private function validarDadosImportacao($param)
    {
        $dadosValidados = [];

        foreach ($param['dados'] as $keys => $itens) {
            foreach ($itens as $key => $item) {
                if ($key == 0) {
                    $dadosValidados[$keys]['id_empresa'] = $item;
                }

                if ($key == 1) {
                    $dadosValidados[$keys]['id_funcionario'] = $item;
                }

                if ($key == 2) {
                    $dadosValidados[$keys]['nome_funcionario'] = $item;
                }

                if ($key == 3) {
                    $dadosValidados[$keys]['data_transacao'] = $item;
                }

                if ($key == 4) {
                    $dadosValidados[$keys]['tipo_evento'] = $item;
                }
            }
        }

        return $dadosValidados;
    }

    public function realizarValidacoesImportacao($dadosParaImportacao)
    {
        return (new ValicadaoService())->realizarValidacaoInsercaoAtualizadaoStatus($dadosParaImportacao);
    }
}
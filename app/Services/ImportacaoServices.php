<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class ImportacaoServices
{
    private $empresaService;
    private $funcionarioService;
    protected $nomeArquivo;
    protected $arquivo;

    public function getNomeArquivo()
    {
        return $this->nomeArquivo;
    }

    public function setNomeArquivo($nomeArquivo)
    {
        $this->nomeArquivo = $nomeArquivo;
        return $this;
    }

    public function getArquivo()
    {
        return $this->arquivo;
    }

    public function setArquivo($arquivo)
    {
        $this->arquivo = $arquivo;
        return $this;
    }

    public function __construct(EmpresaService $empresaService, FuncionarioService $funcionarioService)
    {
        $this->empresaService = $empresaService;
        $this->funcionarioService = $funcionarioService;
    }

    /**
     * Este método tem por finalidade:
     * - ler e validar o arquivo para importação;
     * - persistir os dados no banco de dados;
     * - atualizar os dados no banco de dados.
     *
     */
    public function realizarImportacao()
    {
        $dadosParaImportacao = $this->organizarInformacoesArquivo([
            'dados' => $this->csvToArray()
        ]);

        if (count($dadosParaImportacao) > 0) {
            $dadosPersistencia = $this->realizarValidacoesImportacao($dadosParaImportacao);

            $this->persistirDados($dadosPersistencia['insercao']);
            $this->atualizarDados($dadosPersistencia['atualizacaoStatus']);
        }
    }

    /**
     * Este método tem por finalidade:
     * - verificar a existência do arquivo na pasta definida;
     * - verificar se o arquivo possui a extensão .csv:
     * - ler e converter as informações do arquivo em um array.
     *
     * @param string $delimiter
     * @return array
     */
    private function csvToArray($delimiter = ',')
    {
        $this->setArquivo(Config::get('constants.paths.atual') . $this->getNomeArquivo());

        $this->validaExistenciaArquivo();
        $this->validaExtensaoArquivo();

        $header = null;
        $data = [];

        if (($handle = fopen($this->getArquivo(), 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                $row = array_map("utf8_decode", $row);

                if ($this->validarDadosVazios($row)) {
                    continue;
                }

                $data[] = $row;
            }

            fclose($handle);
        }

        return $data;
    }

    /**
     * Método que verifica a existência de
     * um aqruivo em uma determinada pasta.
     */
    private function validaExistenciaArquivo()
    {
        if (!file_exists($this->getArquivo()) || !is_readable($this->getArquivo())) {
            (new LogService())
                ->setDescricao($this->getNomeArquivo() . ' não existe!')
                ->setTipo('LogAtualizacao')
                ->gerarLog();

            exit('Arquivo inexistente!');
        }
    }

    /**
     * Método que verifica a extensão de um arquivo.
     */
    private function validaExtensaoArquivo()
    {
        if (pathinfo($this->getArquivo())['extension'] != 'csv') {
            (new LogService())
                ->setDescricao('O arquivo '. $this->getNomeArquivo() . ' não possui a extensão .csv!')
                ->setTipo('LogAtualizacao')
                ->gerarLog();

            exit('Arquivo com formato inválido!');
        }
    }

    /**
     * Método que verifica se alguma das colunas
     * do arquivo está vazia. Caso positivo, o
     * sistema gera um log.
     *
     * @param $dados
     * @return bool
     */
    private function validarDadosVazios($dados)
    {
        $mensagem = '';

        if (!$dados[0]) {
            $mensagem = 'Código do cliente vazio!';
        }

        if (!$dados[1]) {
            $mensagem = 'Código do funcionário vazio!';
        }

        if (!$dados[2]) {
            $mensagem = 'Nome do funcionário vazio!';
        }

        if (!$dados[3]) {
            $mensagem = 'Data de processamento vazia!';
        }

        if (!$dados[4]) {
            $mensagem = 'Status vazio!';
        }

        if ($mensagem) {
            (new LogService())
                ->setId(204)
                ->setDescricao($mensagem)
                ->setTipo('LogAtualizacao')
                ->gerarLog();

            return true;
        }

        return false;
    }

    /**
     * Método que organiza as informações extraídas do arquivo
     * pelos nomes das colunas, fornecidas nas regras de
     * avaliação.
     *
     * @param $param
     * @return array
     */
    private function organizarInformacoesArquivo($param)
    {
        $dados = [];

        if ($param['dados']) {
            foreach ($param['dados'] as $keys => $itens) {
                foreach ($itens as $key => $item) {
                    if ($key == 0) {
                        $dados[$keys]['id_empresa'] = $item;
                    }

                    if ($key == 1) {
                        $dados[$keys]['id_funcionario'] = $item;
                    }

                    if ($key == 2) {
                        $dados[$keys]['nome_funcionario'] = $item;
                    }

                    if ($key == 3) {
                        $dados[$keys]['data_transacao'] = $item;
                    }

                    if ($key == 4) {
                        $dados[$keys]['tipo_evento'] = $item;
                    }
                }
            }
        }

        return $dados;
    }

    public function realizarValidacoesImportacao($dadosParaImportacao)
    {
        return (new ValicadaoService())->realizarValidacaoInsercaoAtualizadaoStatus($dadosParaImportacao);
    }

    /**
     * Este método tem por finalidade:
     * - verificar se a empresa que está no elemento do array existe
     *   no banco de dados. Se não existir, faz o insert no banco.
     *   Se existir, gera um log
     *
     * - verificar se o funcionário que está no elemtno do array
     *   existe no banco de dados. Se não existir, faz o insert no banco.
     *   Se existir, gera um log.
     *
     * @param $dadosPersistencia
     * @return bool|string
     */
    private function persistirDados($dadosPersistencia)
    {
        try {
            foreach ($dadosPersistencia['empresa'] as $dadosEmpresa) {
                $idEmpresa = $this->empresaService->getIdEmpresa($dadosEmpresa['id_empresa']);

                if (!$idEmpresa) {
                    $idEmpresa = $this->empresaService->inserir($dadosEmpresa);
                } else {
                    (new LogService())
                        ->setId($idEmpresa)
                        ->setDescricao('Esta empresa já existe no banco de dados!')
                        ->setTipo('LogInserção')
                        ->gerarLog();
                }

                foreach ($dadosPersistencia['funcionario'] as $dadosFuncionario) {
                    if ((int)$dadosFuncionario['empresa_id'] == $idEmpresa) {
                        $idFuncionario = $this->funcionarioService->getIdFuncionario($dadosFuncionario['id_funcionario']);

                        if (!$idFuncionario) {
                            $this->funcionarioService->inserir($dadosFuncionario);
                        } else {
                            (new LogService())
                                ->setId($idFuncionario)
                                ->setDescricao('Esta funcionário já existe no banco de dados!')
                                ->setTipo('LogInserção')
                                ->gerarLog();
                        }
                    }
                }
            }

            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Este método tem por finalidade:
     * - verificar se a empresa em que o funcionário é vinculado existe.
     *   Se a empresa existir, atualiza o status do funcionário. Se não
     *   existir, o sistema gera um log.
     *
     * @param $dadosPersistencia
     * @return bool|string
     */
    private function atualizarDados($dadosPersistencia)
    {
        try {
            foreach ($dadosPersistencia['funcionario'] as $dadosFuncionario) {
                $idEmpresa = $this->empresaService->getIdEmpresa($dadosFuncionario['empresa_id']);

                if ($idEmpresa) {
                    $this->funcionarioService->atualizarStatus($dadosFuncionario);
                } else {
                    (new LogService())
                        ->setId($dadosFuncionario['empresa_id'])
                        ->setDescricao('Esta empresa não existe no banco de dados!')
                        ->setTipo('LogAtualização')
                        ->gerarLog();
                }
            }

            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Método para mover os arquivos, após a realização do processamento.
     *
     * @return mixed
     */
    public function moverArquivos()
    {
        return Storage::move('arquivos-a-processar\\' . $this->getNomeArquivo(), 'arquivos-processados\\' . $this->getNomeArquivo());
    }
}
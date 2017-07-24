<?php

namespace App\Services;

class ValicadaoService
{
    /**
     * Este método tem por finalidade:
     * - separar os dados que serão inseridos no banco;
     * - separar os dados que serão atualizados no banco.
     *
     * @param $dadosParaImportacao
     * @return array
     */
    public function realizarValidacaoInsercaoAtualizadaoStatus($dadosParaImportacao)
    {
        $dados['insercao'] = $dados['atualizadaoStatus'] = [];

        if (count($dadosParaImportacao) > 0) {
            foreach ($dadosParaImportacao as $key => $item) {
                if ($item['tipo_evento'] === 'I') {
                    $dados['insercao'][$key] = $item;
                }

                if ($item['tipo_evento'] === 'E') {
                    $dados['atualizadaoStatus'][$key] = $item;
                }
            }
        }

        return $this->separarDadosEntidades($dados);
    }

    /**
     * Este método tem por finalidade:
     * - separar os dados de inserção e atualização da entidade "Empresa";
     * - separar os dados de inserção e atualização da entidade "Funcionário".
     *
     * @param $dadosInsercaoAtualizacao
     * @return array
     */
    private function separarDadosEntidades($dadosInsercaoAtualizacao)
    {
        $dadosInsercao = $dadosAtualizacao = [];

        if (count($dadosInsercaoAtualizacao['insercao']) > 0) {
            foreach ($dadosInsercaoAtualizacao['insercao'] as $key => $item) {
                $dadosInsercao['empresa'][$key]['id_empresa'] = $item['id_empresa'];
                $dadosInsercao['empresa'][$key]['data_transacao'] = $this->alteraOrdemData($item['data_transacao']);

                $dadosInsercao['funcionario'][$key]['id_funcionario'] = $item['id_funcionario'];
                $dadosInsercao['funcionario'][$key]['empresa_id'] = $item['id_empresa'];
                $dadosInsercao['funcionario'][$key]['nome'] = $item['nome_funcionario'];
                $dadosInsercao['funcionario'][$key]['data_transacao'] = $this->alteraOrdemData($item['data_transacao']);
            }
        }

        if (count($dadosInsercaoAtualizacao['atualizadaoStatus']) > 0) {
            foreach ($dadosInsercaoAtualizacao['atualizadaoStatus'] as $key => $item) {
                $dadosAtualizacao['empresa'][$key]['id_empresa'] = $item['id_empresa'];
                $dadosAtualizacao['empresa'][$key]['data_transacao'] = $this->alteraOrdemData($item['data_transacao']);

                $dadosAtualizacao['funcionario'][$key]['id_funcionario'] = $item['id_funcionario'];
                $dadosAtualizacao['funcionario'][$key]['empresa_id'] = $item['id_empresa'];
                $dadosAtualizacao['funcionario'][$key]['nome'] = $item['nome_funcionario'];
                $dadosAtualizacao['funcionario'][$key]['data_transacao'] = $this->alteraOrdemData($item['data_transacao']);
            }
        }

        return [
            'insercao' => $dadosInsercao,
            'atualizacaoStatus' => $dadosAtualizacao
        ];
    }

    private function alteraOrdemData($dadosData)
    {
        $dados = explode('/', $dadosData);
        return $dados[2] . '-' . $dados[1] . '-' . $dados[0];
    }
}
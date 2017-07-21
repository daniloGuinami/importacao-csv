<?php

namespace App\Services;

class ValicadaoService
{
    public function realizarValidacaoInsercaoAtualizadaoStatus($dadosParaImportacao)
    {
        $dados = [];
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

    private function separarDadosEntidades($dadosInsercaoAtualizacao)
    {
        $dadosInsercao = $dadosAtualizacao = [];

        foreach ($dadosInsercaoAtualizacao['insercao'] as $key => $item) {
            $dadosInsercao['empresa'][$key]['id_empresa'] = $item['id_empresa'];
            $dadosInsercao['empresa'][$key]['data_transacao'] = $item['data_transacao'];

            $dadosInsercao['funcionario'][$key]['id_funcionario'] = $item['id_funcionario'];
            $dadosInsercao['funcionario'][$key]['nome_funcionario'] = $item['nome_funcionario'];
            $dadosInsercao['funcionario'][$key]['data_transacao'] = $item['data_transacao'];
        }

        foreach ($dadosInsercaoAtualizacao['atualizadaoStatus'] as $key => $item) {
            $dadosAtualizacao['empresa'][$key]['id_empresa'] = $item['id_empresa'];
            $dadosAtualizacao['empresa'][$key]['data_transacao'] = $item['data_transacao'];

            $dadosAtualizacao['funcionario'][$key]['id_funcionario'] = $item['id_funcionario'];
            $dadosAtualizacao['funcionario'][$key]['nome_funcionario'] = $item['nome_funcionario'];
            $dadosAtualizacao['funcionario'][$key]['data_transacao'] = $item['data_transacao'];
        }

        return [
            'insercao' => $dadosInsercao,
            'atualizacaoStatus' => $dadosAtualizacao
        ];
    }

}
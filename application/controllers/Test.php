<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

    public function index() {
        $testes = [
            ['label' => 'Conexão com Banco de Dados', 'metodo' => 'conexaoBanco'],
            ['label' => 'Validação de Entrada JSON', 'metodo' => 'validaEntrada'],
            ['label' => 'Geração de XML Simulado', 'metodo' => 'gerarXmlTeste'],
            ['label' => 'Executar Migração do Banco', 'metodo' => 'executarMigracao'],
            ['label' => 'Criar Tabela Notas Fiscais', 'metodo' => 'criarTabelaNotasFiscais']
        ];

        $this->load->view('test/menu', ['testes' => $testes]);
    }

    public function conexaoBanco() {
        $this->load->model('NotaFiscal_model');
        $dados = $this->NotaFiscal_model->getNotasRecentes();
        $this->load->view('test/resultado', ['resultado' => $dados]);
    }

    public function validaEntrada() {
        $json = file_get_contents(APPPATH . 'data/exemplo_nfse.json');
        $dados = json_decode($json, true);
        $this->load->view('test/resultado', ['resultado' => $dados]);
    }

    public function gerarXmlTeste() {
        $this->load->library('nfse');
        $xml = $this->nfse->gerarXmlSimulado();
        $this->load->view('test/resultado', ['resultado' => htmlspecialchars($xml)]);
    }

    public function executarMigracao() {
        $this->load->model('Migracao_model');
        $resultado = $this->Migracao_model->executar();
        $this->load->view('test/resultado', ['resultado' => $resultado]);
    }

    public function criarTabelaNotasFiscais() {
        $this->load->model('Migracao_model');
        $resultado = $this->Migracao_model->criarTabelaNotasFiscais();
        $this->load->view('test/resultado', ['resultado' => $resultado]);
    }
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NotaFiscal_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function getNotasRecentes() {
        // AIDEV-GENERATED: Método para testar a conexão com o banco de dados.
        // Retorna um array vazio ou dados de uma tabela existente para verificar a conexão.
        // Por enquanto, apenas um teste simples de conectividade.
        try {
            $query = $this->db->query('SELECT 1 as test_connection');
            return $query->result_array();
        } catch (Exception $e) {
            // AIDEV-GENERATED: Exibindo erro de conexão com o banco de dados para depuração.
            echo 'Erro de Conexão com o Banco de Dados: ' . $e->getMessage();
            return [];
        }
    }

    public function salvarNotaFiscal($dados_nf) {
        // AIDEV-GENERATED: Método para salvar os dados da nota fiscal na tabela `notas_fiscais`.
        // Os campos `created_at` e `updated_at` serão preenchidos automaticamente.
        $dados_nf['created_at'] = date('Y-m-d H:i:s');
        $dados_nf['updated_at'] = date('Y-m-d H:i:s');

        $dados_nf['cnpj_remetente'] = $dados_nf['cnpj'];
        unset($dados_nf['cnpj']);

        // Converte o booleano para TINYINT (0 ou 1) para o banco de dados
        $dados_nf['iss_retido'] = (int) $dados_nf['iss_retido'];

        // Converte arrays para JSON para campos TEXT
        if (isset($dados_nf['endereco_tomador']) && is_array($dados_nf['endereco_tomador'])) {
            $dados_nf['endereco_tomador'] = json_encode($dados_nf['endereco_tomador']);
        }

        $this->db->insert('notas_fiscais', $dados_nf);
        return $this->db->insert_id();
    }

    public function getTodasNotas() {
        // AIDEV-GENERATED: Método para buscar todas as notas fiscais salvas no banco de dados.
        $query = $this->db->get('notas_fiscais');
        return $query->result_array();
    }

    public function getNotaById($id) {
        // AIDEV-GENERATED: Método para buscar uma nota fiscal pelo ID.
        $query = $this->db->get_where('notas_fiscais', ['id' => $id]);
        return $query->row_array();
    }

    public function excluirNotaFiscal($id) {
        // AIDEV-GENERATED: Método para excluir uma nota fiscal pelo ID.
        $this->db->delete('notas_fiscais', ['id' => $id]);
    }
}

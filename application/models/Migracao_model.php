<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migracao_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        // AIDEV-NOTE: O carregamento do banco de dados aqui é opcional, dependendo se a migração interage diretamente com ele.
        // $this->load->database();
    }

    public function executar() {
        // AIDEV-GENERATED: Método simulado para execução de migração.
        // Em um cenário real, este método conteria a lógica para aplicar as migrações do banco de dados.
        return ['status' => 'Migração simulada executada com sucesso.', 'timestamp' => date('Y-m-d H:i:s')];
    }

    public function criarTabelaNotasFiscais() {
        // AIDEV-GENERATED: Método para criar a tabela `notas_fiscais`.
        $this->load->dbforge();

        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'cnpj_remetente' => array(
                'type' => 'VARCHAR',
                'constraint' => '14',
            ),
            'inscricao_prestador' => array(
                'type' => 'VARCHAR',
                'constraint' => '8',
            ),
            'numero_rps' => array(
                'type' => 'VARCHAR',
                'constraint' => '12',
            ),
            'serie_rps' => array(
                'type' => 'VARCHAR',
                'constraint' => '5',
            ),
            'tipo_rps' => array(
                'type' => 'VARCHAR',
                'constraint' => '5',
            ),
            'data_emissao' => array(
                'type' => 'DATE',
            ),
            'status_rps' => array(
                'type' => 'VARCHAR',
                'constraint' => '1',
            ),
            'tributacao_rps' => array(
                'type' => 'VARCHAR',
                'constraint' => '1',
            ),
            'valor_servicos' => array(
                'type' => 'DECIMAL',
                'constraint' => '15,2',
            ),
            'valor_deducoes' => array(
                'type' => 'DECIMAL',
                'constraint' => '15,2',
            ),
            'codigo_servico' => array(
                'type' => 'VARCHAR',
                'constraint' => '5',
            ),
            'aliquota_servicos' => array(
                'type' => 'DECIMAL',
                'constraint' => '5,4',
            ),
            'iss_retido' => array(
                'type' => 'TINYINT',
                'constraint' => '1',
            ),
            'discriminacao' => array(
                'type' => 'TEXT',
            ),
            'cnpj_tomador' => array(
                'type' => 'VARCHAR',
                'constraint' => '14',
                'null' => TRUE
            ),
            'razao_social_tomador' => array(
                'type' => 'VARCHAR',
                'constraint' => '75',
                'null' => TRUE
            ),
            'endereco_tomador' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'email_tomador' => array(
                'type' => 'VARCHAR',
                'constraint' => '75',
                'null' => TRUE
            ),
            'xml_enviado' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'resposta_prefeitura' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'status_integracao' => array(
                'type' => 'VARCHAR',
                'constraint' => '20',
                'default' => 'pendente'
            ),
            'created_at' => array(
                'type' => 'DATETIME',
                'null' => TRUE
            ),
            'updated_at' => array(
                'type' => 'DATETIME',
                'null' => TRUE
            )
        ));

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('notas_fiscais', TRUE);

        return ['status' => 'Tabela notas_fiscais criada/verificada com sucesso.'];
    }
}

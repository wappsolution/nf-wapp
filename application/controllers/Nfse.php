<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nfse extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // AIDEV-NOTE: Carregar helpers ou bibliotecas necessárias aqui.
        $this->load->helper('url'); // Para usar site_url()
        $this->load->library('nfse_paulistana'); // AIDEV-GENERATED: Carrega a biblioteca Nfse_paulistana
    }

    public function receber_json() {
        // AIDEV-GENERATED: Endpoint para recebimento de JSON.
        $json_data = file_get_contents('php://input');
        log_message('debug', 'JSON recebido: ' . $json_data);
        $data = json_decode($json_data, true);
        log_message('debug', 'Dados decodificados: ' . print_r($data, true));

        if (json_last_error() !== JSON_ERROR_NONE) {
            log_message('error', 'Erro ao decodificar JSON: ' . json_last_error_msg());
            echo json_encode(['status' => 'error', 'message' => 'JSON inválido.']);
            return;
        }

        // AIDEV-GENERATED: Validação de campos obrigatórios (CNPJ e outros campos essenciais do RPS).
        $required_fields = [
            'cnpj', // CNPJ do remetente/prestador
            'inscricao_prestador',
            'numero_rps',
            'tipo_rps',
            'data_emissao',
            'status_rps',
            'tributacao_rps',
            'valor_servicos',
            'valor_deducoes',
            'codigo_servico',
            'aliquota_servicos',
            'iss_retido',
            'discriminacao',
            'razao_social_tomador',
            'cnpj_tomador',
            'endereco_tomador',
            'email_tomador'
        ];

        foreach ($required_fields as $field) {
            if (!isset($data[$field])) {
                echo json_encode(['status' => 'error', 'message' => 'O campo ' . $field . ' é obrigatório.']);
                return;
            }
            // AIDEV-NOTE: Validação específica para campos que não podem ser strings vazias.
            if (is_string($data[$field]) && empty($data[$field]) && $field !== 'iss_retido') {
                echo json_encode(['status' => 'error', 'message' => 'O campo ' . $field . ' não pode ser vazio.']);
                return;
            }
        }

        // AIDEV-TODO: Adicionar validação mais robusta para o formato do CNPJ e outros campos conforme os schemas XSD.

        // AIDEV-GENERATED: Salva os dados da nota fiscal no banco de dados.
        $this->load->model('NotaFiscal_model');
        $id_nota = $this->NotaFiscal_model->salvarNotaFiscal($data);

        echo json_encode(['status' => 'success', 'message' => 'Dados recebidos e salvos com sucesso.', 'id_nota' => $id_nota, 'received_data' => $data]);
    }

    public function simular() {
        // AIDEV-GENERATED: Função para simular o envio de dados JSON usando a biblioteca Nfse_paulistana.
        // Dados completos baseados na análise dos schemas XML (XSD).
        $dados_nf = [
            'Cabecalho' => [
                'CPFCNPJRemetente' => [
                    'CNPJ' => '11222333000144' // CNPJ do prestador que está enviando o RPS
                ],
                'Versao' => '1'
            ],
            'RPS' => [
                'Assinatura' => 'ASSINATURA_DIGITAL_DO_RPS_PLACEHOLDER', // Placeholder para a assinatura digital
                'ChaveRPS' => [
                    'InscricaoPrestador' => '12345678',
                    'SerieRPS' => 'A',
                    'NumeroRPS' => '000000000001'
                ],
                'TipoRPS' => 'RPS',
                'DataEmissao' => date('Y-m-d'),
                'StatusRPS' => 'N',
                'TributacaoRPS' => 'T',
                'ValorServicos' => '1500.75', // Formato com ponto decimal
                'ValorDeducoes' => '0.00',
                'CodigoServico' => '0101',
                'AliquotaServicos' => '0.0500',
                'ISSRetido' => false,
                'Discriminacao' => 'Serviços de consultoria em TI conforme contrato XXXXX.',
                // Tomador (se PJ)
                'CPFCNPJTomador' => [
                    'CNPJ' => '99887766000155'
                ],
                'RazaoSocialTomador' => 'Empresa Tomadora de Serviços Ltda.',
                'EnderecoTomador' => [
                    'TipoLogradouro' => 'Rua',
                    'Logradouro' => 'Exemplo',
                    'NumeroEndereco' => '123',
                    'Bairro' => 'Centro',
                    'Cidade' => '3550308', // Código IBGE de São Paulo
                    'UF' => 'SP',
                    'CEP' => '01000000'
                ],
                'EmailTomador' => 'tomador@exemplo.com'
            ]
        ];

        // Constrói o array de dados para enviar ao receber_json, achatando a estrutura
        $data_to_send = [
            'cnpj' => $dados_nf['Cabecalho']['CPFCNPJRemetente']['CNPJ'],
            'inscricao_prestador' => $dados_nf['RPS']['ChaveRPS']['InscricaoPrestador'],
            'serie_rps' => $dados_nf['RPS']['ChaveRPS']['SerieRPS'], // AIDEV-GENERATED: Adicionado para salvar no banco
            'numero_rps' => $dados_nf['RPS']['ChaveRPS']['NumeroRPS'],
            'tipo_rps' => $dados_nf['RPS']['TipoRPS'],
            'data_emissao' => $dados_nf['RPS']['DataEmissao'],
            'status_rps' => $dados_nf['RPS']['StatusRPS'],
            'tributacao_rps' => $dados_nf['RPS']['TributacaoRPS'],
            'valor_servicos' => $dados_nf['RPS']['ValorServicos'],
            'valor_deducoes' => $dados_nf['RPS']['ValorDeducoes'],
            'codigo_servico' => $dados_nf['RPS']['CodigoServico'],
            'aliquota_servicos' => $dados_nf['RPS']['AliquotaServicos'],
            'iss_retido' => $dados_nf['RPS']['ISSRetido'],
            'discriminacao' => $dados_nf['RPS']['Discriminacao'],
            'razao_social_tomador' => $dados_nf['RPS']['RazaoSocialTomador'],
            'cnpj_tomador' => $dados_nf['RPS']['CPFCNPJTomador']['CNPJ'],
            'endereco_tomador' => $dados_nf['RPS']['EnderecoTomador'],
            'email_tomador' => $dados_nf['RPS']['EmailTomador']
        ];

        // Simula o envio para o endpoint receber_json
        $ch = curl_init(site_url('nfse/receber_json'));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data_to_send));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen(json_encode($data_to_send))
        ]);

        $result = curl_exec($ch);
        curl_close($ch);

        $resultado_receber_json = json_decode($result, true);

        // AIDEV-GENERATED: Carrega a view para exibir o resultado formatado.
        $this->load->view('nfse_simulacao_resultado', ['resultado' => $resultado_receber_json, 'origin' => 'simular']);
    }

    public function simular_sem_cnpj() {
        // AIDEV-GENERATED: Função para simular o envio de dados JSON sem CNPJ para teste de validação.
        $dados_simulados = [
            'razao_social' => 'Empresa Teste S.A. (Sem CNPJ)',
            'servico' => 'Consultoria',
            'valor' => 999.99,
            'data' => date('Y-m-d')
        ];

        // Simula o envio para o endpoint receber_json
        $ch = curl_init(site_url('nfse/receber_json'));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dados_simulados));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen(json_encode($dados_simulados))
        ]);

        $result = curl_exec($ch);
        curl_close($ch);

        $resultado_receber_json = json_decode($result, true);

        // AIDEV-GENERATED: Carrega a view para exibir o resultado formatado.
        $this->load->view('nfse_simulacao_resultado', ['resultado' => $resultado_receber_json, 'origin' => 'simular_sem_cnpj']);
    }

    public function listar_notas() {
        // AIDEV-GENERATED: Lista todas as notas fiscais salvas no banco de dados.
        $this->load->model('NotaFiscal_model');
        $data['notas'] = $this->NotaFiscal_model->getTodasNotas();
        $this->load->view('nfse_lista_notas', $data);
    }

    public function excluir_nota($id) {
        // AIDEV-GENERATED: Exclui uma nota fiscal do banco de dados.
        $this->load->model('NotaFiscal_model');
        $this->NotaFiscal_model->excluirNotaFiscal($id);
        redirect('nfse/listar_notas'); // Redireciona de volta para a lista
    }

    public function gerar_xml_nota($id) {
        // AIDEV-GENERATED: Gera o XML de uma nota fiscal a partir dos dados do banco de dados.
        $this->load->model('NotaFiscal_model');
        $nota = $this->NotaFiscal_model->getNotaById($id);

        if (!$nota) {
            show_404(); // Ou exiba uma mensagem de erro
            return;
        }

        // Reconstroi a estrutura de dados esperada pela Nfse_paulistana::gerarXmlNfse
        $dados_nf = [
            'Cabecalho' => [
                'CPFCNPJRemetente' => [
                    'CNPJ' => $nota['cnpj_remetente']
                ],
                'Versao' => '1'
            ],
            'RPS' => [
                'Assinatura' => 'ASSINATURA_DIGITAL_DO_RPS_PLACEHOLDER',
                'ChaveRPS' => [
                    'InscricaoPrestador' => $nota['inscricao_prestador'],
                    'SerieRPS' => $nota['serie_rps'],
                    'NumeroRPS' => $nota['numero_rps']
                ],
                'TipoRPS' => $nota['tipo_rps'],
                'DataEmissao' => $nota['data_emissao'],
                'StatusRPS' => $nota['status_rps'],
                'TributacaoRPS' => $nota['tributacao_rps'],
                'ValorServicos' => $nota['valor_servicos'],
                'ValorDeducoes' => $nota['valor_deducoes'],
                'CodigoServico' => $nota['codigo_servico'],
                'AliquotaServicos' => $nota['aliquota_servicos'],
                'ISSRetido' => (bool)$nota['iss_retido'],
                'Discriminacao' => $nota['discriminacao'],
                'CPFCNPJTomador' => [
                    'CNPJ' => $nota['cnpj_tomador']
                ],
                'RazaoSocialTomador' => $nota['razao_social_tomador'],
                'EnderecoTomador' => json_decode($nota['endereco_tomador'], true),
                'EmailTomador' => $nota['email_tomador']
            ]
        ];

        $xml_gerado = $this->nfse_paulistana->gerarXmlNfse($dados_nf);

        // AIDEV-GENERATED: Valida o XML gerado contra o XSD.
        $xsd_path = APPPATH . '..\docs\nfse_paulistana\schemasv02\schemasv02\nfse\PedidoEnvioRPS_v01.xsd';
        $validacao_xsd = $this->nfse_paulistana->validarXmlContraXSD($xml_gerado, $xsd_path);

        $resultado_envio = [
            'status' => 'sucesso',
            'mensagem' => 'XML gerado com sucesso.',
            'xml_enviado' => $xml_gerado,
            'id_nota' => $id
        ];

        $this->load->view('nfse_simulacao_resultado', ['resultado' => $resultado_envio, 'origin' => 'gerar_xml_nota', 'validacao_xsd' => $validacao_xsd]);
    }
}

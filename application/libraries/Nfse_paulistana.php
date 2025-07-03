<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use NFePHP\NFe\Tools;

// AIDEV-GENERATED: Biblioteca para encapsular a lógica da NFS-e Paulistana.
class Nfse_paulistana {

    protected $CI;
    protected $cert_path;
    protected $cert_password;

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->config->load('config', TRUE);
        $this->cert_path = $this->CI->config->item('nfse_cert_path');
        $this->cert_password = $this->CI->config->item('nfse_cert_password');

        // AIDEV-TODO: Carregar configurações específicas da NFS-e Paulistana (certificados, URLs de webservice, etc.).
    }

    /**
     * AIDEV-GENERATED: Simula a geração do XML da NFS-e.
     * Em um cenário real, esta função construiria o XML com base nos dados da nota.
     * @param array $dados_nf Dados da Nota Fiscal.
     * @return string XML da NFS-e (simulado).
     */
    public function gerarXmlNfse(array $dados_nf) {
        // AIDEV-GENERATED: Implementação da lógica real de geração de XML conforme o layout da NFS-e Paulistana (PedidoEnvioRPS_v01.xsd).
        // Utiliza DOMDocument para controle preciso de namespaces.

        $dom = new DOMDocument('1.0', 'utf-8');
        $dom->formatOutput = true;

        $root = $dom->createElementNS('http://www.prefeitura.sp.gov.br/nfe', 'PedidoEnvioRPS');
        $root->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:tipos', 'http://www.prefeitura.sp.gov.br/nfe/tipos');
        $root->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:ds', 'http://www.w3.org/2000/09/xmldsig#');
        $dom->appendChild($root);

        // Cabecalho
        $cabecalho = $dom->createElementNS('', 'Cabecalho'); // AIDEV-GENERATED: Criado sem namespace para validação XSD
        $cabecalho->setAttribute('Versao', $dados_nf['Cabecalho']['Versao']);
        $cpfCnpjRemetente = $dom->createElement('CPFCNPJRemetente');
        $cpfCnpjRemetente->appendChild($dom->createElement('CNPJ', $dados_nf['Cabecalho']['CPFCNPJRemetente']['CNPJ']));
        $cabecalho->appendChild($cpfCnpjRemetente);
        $root->appendChild($cabecalho);

        // RPS
        $rps = $dom->createElementNS('', 'RPS'); // AIDEV-GENERATED: Criado sem namespace para validação XSD
        $rps->appendChild($dom->createElement('Assinatura', base64_encode('DUMMY_ASSINATURA_RPS')));

        $chaveRPS = $dom->createElement('ChaveRPS');
        $chaveRPS->appendChild($dom->createElement('InscricaoPrestador', $dados_nf['RPS']['ChaveRPS']['InscricaoPrestador']));
        $chaveRPS->appendChild($dom->createElement('SerieRPS', $dados_nf['RPS']['ChaveRPS']['SerieRPS']));
        $chaveRPS->appendChild($dom->createElement('NumeroRPS', $dados_nf['RPS']['ChaveRPS']['NumeroRPS']));
        $rps->appendChild($chaveRPS);

        $rps->appendChild($dom->createElement('TipoRPS', $dados_nf['RPS']['TipoRPS']));
        $rps->appendChild($dom->createElement('DataEmissao', $dados_nf['RPS']['DataEmissao']));
        $rps->appendChild($dom->createElement('StatusRPS', $dados_nf['RPS']['StatusRPS']));
        $rps->appendChild($dom->createElement('TributacaoRPS', $dados_nf['RPS']['TributacaoRPS']));
        $rps->appendChild($dom->createElement('ValorServicos', $dados_nf['RPS']['ValorServicos']));
        $rps->appendChild($dom->createElement('ValorDeducoes', $dados_nf['RPS']['ValorDeducoes']));
        $rps->appendChild($dom->createElement('CodigoServico', $dados_nf['RPS']['CodigoServico']));
        $rps->appendChild($dom->createElement('AliquotaServicos', $dados_nf['RPS']['AliquotaServicos']));
        $rps->appendChild($dom->createElement('ISSRetido', $dados_nf['RPS']['ISSRetido'] ? 'true' : 'false'));

        // AIDEV-GENERATED: Adiciona os elementos do Tomador diretamente ao RPS, conforme o XSD
        if (isset($dados_nf['RPS']['CPFCNPJTomador']['CNPJ'])) {
            $cpfCnpjTomador = $dom->createElement('CPFCNPJTomador');
            $cpfCnpjTomador->appendChild($dom->createElement('CNPJ', $dados_nf['RPS']['CPFCNPJTomador']['CNPJ']));
            $rps->appendChild($cpfCnpjTomador);
        }
        $rps->appendChild($dom->createElement('RazaoSocialTomador', $dados_nf['RPS']['RazaoSocialTomador']));

        $enderecoTomador = $dom->createElement('EnderecoTomador');
        $enderecoTomador->appendChild($dom->createElement('TipoLogradouro', $dados_nf['RPS']['EnderecoTomador']['TipoLogradouro']));
        $enderecoTomador->appendChild($dom->createElement('Logradouro', $dados_nf['RPS']['EnderecoTomador']['Logradouro']));
        $enderecoTomador->appendChild($dom->createElement('NumeroEndereco', $dados_nf['RPS']['EnderecoTomador']['NumeroEndereco']));
        $enderecoTomador->appendChild($dom->createElement('Bairro', $dados_nf['RPS']['EnderecoTomador']['Bairro']));
        $enderecoTomador->appendChild($dom->createElement('Cidade', $dados_nf['RPS']['EnderecoTomador']['Cidade']));
        $enderecoTomador->appendChild($dom->createElement('UF', $dados_nf['RPS']['EnderecoTomador']['UF']));
        $enderecoTomador->appendChild($dom->createElement('CEP', $dados_nf['RPS']['EnderecoTomador']['CEP']));
        $rps->appendChild($enderecoTomador);

        $rps->appendChild($dom->createElement('EmailTomador', $dados_nf['RPS']['EmailTomador']));

        $rps->appendChild($dom->createElement('Discriminacao', $dados_nf['RPS']['Discriminacao']));

        $root->appendChild($rps);

        // AIDEV-GENERATED: Assinatura digital do XML usando NFePHP
        try {
            $tools = new Tools($this->cert_path, $this->cert_password);
            $xml_unsigned = $dom->saveXML();
            $xml_signed = $tools->signXML($xml_unsigned, 'PedidoEnvioRPS'); // Assina o elemento PedidoEnvioRPS

            return $xml_signed;

        } catch (\Exception $e) {
            log_message('error', 'Erro ao assinar XML: ' . $e->getMessage());
            // AIDEV-TODO: Tratar o erro de assinatura de forma mais robusta
            return 'Erro ao assinar XML: ' . $e->getMessage();
        }
    }

    /**
     * AIDEV-GENERATED: Simula o envio do XML da NFS-e via SOAP para a Prefeitura de São Paulo.
     * @param string $xml_nf XML da NFS-e a ser enviado.
     * @return array Resultado do envio (simulado).
     */
    public function enviarXmlNfse($xml_nf) {
        // AIDEV-TODO: Implementar a lógica real de comunicação SOAP com o webservice da Prefeitura de São Paulo.
        // Isso envolveria o uso de cURL ou SoapClient para enviar o XML e processar a resposta.
        return ['status' => 'sucesso', 'mensagem' => 'Envio SOAP simulado com sucesso.', 'xml_enviado' => $xml_nf];
    }

    /**
     * AIDEV-GENERATED: Valida um XML contra um schema XSD.
     * @param string $xml_content Conteúdo do XML a ser validado.
     * @param string $xsd_path Caminho absoluto para o arquivo XSD.
     * @return array Resultado da validação (true/false e mensagens de erro).
     */
    public function validarXmlContraXSD($xml_content, $xsd_path) {
        libxml_use_internal_errors(true);

        $dom = new DOMDocument();
        $dom->loadXML($xml_content);

        if (!$dom->schemaValidate($xsd_path)) {
            $errors = [];
            foreach (libxml_get_errors() as $error) {
                $errors[] = sprintf("[%s %s] %s (Linha: %d, Coluna: %d)",
                    $error->level == LIBXML_ERR_WARNING ? 'WARNING' : 'ERROR',
                    $error->code,
                    trim($error->message),
                    $error->line,
                    $error->column
                );
            }
            libxml_clear_errors();
            return ['valid' => false, 'errors' => $errors];
        }

        libxml_clear_errors();
        return ['valid' => true, 'errors' => []];
    }
}

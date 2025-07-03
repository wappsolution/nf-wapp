# Projeto Conector de Nota Fiscal (NFS-e) – Setup e Diretrizes

## ⚙️ Configuração Inicial

1. **Remoção de `index.php` da URL:**
   A configuração padrão do CodeIgniter deve ser ajustada para ocultar `index.php` da URL. Essa é uma etapa obrigatória de setup e está detalhada na documentação oficial do CodeIgniter 3.

2. **Banco de Dados:**  
   Configure as credenciais de acesso no arquivo `application/config/database.php`.

3. **URL Base:**  
   Defina a base URL correta no arquivo `application/config/config.php`.

4. **Chave de Criptografia:**  
   No mesmo arquivo de config, defina uma chave forte em `$config['encryption_key']`.

---

## 🗂 Estrutura de Arquivos

- `application/`: Contém controllers, models, views, helpers, etc.
- `system/`: Core do framework CodeIgniter (não modificar).
- `index.php`: Front controller da aplicação.

---

## 💻 Tecnologias Utilizadas

- **PHP:** 5.6.40
- **Framework:** CodeIgniter 3.x
- **Banco de Dados:** MySQL
- **Biblioteca de Nota Fiscal:** NFePHP (sped-nfse)
- **Protocolo de Envio:** SOAP/XML com a Prefeitura de São Paulo
- **Assinatura Digital:** Certificado A1 (.pfx)
- **Modelagem de Dados:** Prisma (documentação, fora do PHP)

---

## 🧱 Arquitetura Padrão (MVC)

### Controllers
- Responsáveis por receber e validar requisições.
- Disparam chamadas de geração e envio da NFS-e.
- Nunca devem conter SQL direto.

### Models
- Realizam acesso e manipulação do banco de dados.
- Armazenam dados como: XMLs, status, erros, protocolos, timestamps.
- Isentos de regras de negócio ou SOAP.

### Views
- Utilizadas apenas para visualização auxiliar (teste/debug).
- Nunca contêm lógica de negócio.

---

## 🔁 Fluxo Padrão de Desenvolvimento

1. Criar ou atualizar Controller responsável pela entrada de dados.
2. Validar estrutura e campos recebidos (somente CNPJ).
3. Salvar dados temporários no banco via Model.
4. Gerar e assinar XML usando NFePHP.
5. Enviar via SOAP para a Prefeitura de SP.
6. Armazenar XMLs enviados e respostas.
7. Atualizar status da nota conforme retorno da prefeitura.

---

## 📑 Regras Gerais

- Toda lógica de banco deve estar encapsulada em Models.
- Controllers devem conter apenas fluxo de validação, controle e resposta.
- Não misturar responsabilidades entre camadas.
- Toda função deve ser curta e ter propósito único.
- Todo código assistido por IA deve conter comentário âncora apropriado.

---

## 🧪 Testes

- A controller `Test.php` será usada como base para testes manuais e automações.
- A migração do banco de dados será executada diretamente por um método dessa controller, acessível por link direto.
- Exibir resultados com:
  ```php
  echo '<pre>'; print_r($variavel); exit;

## 🧠 Comentários Âncora para Código Gerado por IA
Utilize os seguintes comentários especiais no código para rastreabilidade:

```php
// AIDEV-NOTE: explicação técnica de decisão
// AIDEV-TODO: ponto a melhorar manualmente depois
// AIDEV-QUESTION: dúvida gerada durante desenvolvimento
// AIDEV-GENERATED: código gerado por IA
```
## 🎯 Controller de Teste: Test.php
```php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

    public function index() {
        $testes = [
            ['label' => 'Conexão com Banco de Dados', 'metodo' => 'conexaoBanco'],
            ['label' => 'Validação de Entrada JSON', 'metodo' => 'validaEntrada'],
            ['label' => 'Geração de XML Simulado', 'metodo' => 'gerarXmlTeste'],
            ['label' => 'Executar Migração do Banco', 'metodo' => 'executarMigracao']
        ];

        $this->load->view('test/menu', ['testes' => $testes]);
    }

    public function conexaoBanco() {
        $this->load->model('NotaFiscal_model');
        $dados = $this->NotaFiscal_model->getNotasRecentes();
        echo '<pre>'; print_r($dados);
    }

    public function validaEntrada() {
        $json = file_get_contents(APPPATH . 'data/exemplo_nfse.json');
        $dados = json_decode($json, true);
        echo '<pre>'; print_r($dados);
    }

    public function gerarXmlTeste() {
        $this->load->library('nfse');
        $xml = $this->nfse->gerarXmlSimulado();
        echo htmlspecialchars($xml);
    }

    public function executarMigracao() {
        $this->load->model('Migracao_model');
        $resultado = $this->Migracao_model->executar();
        echo '<pre>'; print_r($resultado);
    }
}
```
## ✅ To-do por Sprint
🟠 Sprint 1 – Setup
- [x] Estrutura do CodeIgniter criada
- [x] Banco configurado
- [x] URL base e index removido da URL
- [x] Controller de testes criada
- [x] Função de migração disponível

🟡 Sprint 2 – Recepção e Geração
- [ ] **PAUSADO: Dependência de Certificado A1 válido e Ambiente de Homologação da Prefeitura.**
- [x] Endpoint para recebimento de JSON (somente PJ)
- [ ] Validação de campos obrigatórios
- [x] Armazenamento inicial no banco
- [ ] Geração de XML via NFePHP
- [ ] Assinatura digital com certificado A1

🟢 Sprint 3 – Envio e Resposta
- [ ] Envio de XML via SOAP à Prefeitura
- [ ] Armazenamento de resposta, status e protocolo
- [ ] Atualização de status conforme retorno

🔵 Sprint 4 – Monitoramento e Controle
- [ ] Consulta manual/automática por protocolo
- [ ] Tela simples de logs e falhas
- [ ] Reprocessamento de notas com erro

## Instrução para Assistentes de IA

Antes de atualizar qualquer item como concluído (marcar com `- [x]`), **pergunte explicitamente ao usuário se a tarefa realmente foi finalizada**.

### Exemplo:
Usuário: "Atualize o progresso"
IA: "Você confirma que deseja marcar como concluído o item: 'Criar controller de testes (`Test.php`) com métodos básicos'?"

Somente após a confirmação do usuário, a IA deve atualizar o `.md`.

Essa confirmação deve ser feita **para cada item individual** sugerido para marcação.

## 📌 Observações Finais
O sistema operará exclusivamente com tomadores pessoa jurídica (CNPJ).
Toda integração segue o padrão da Prefeitura de São Paulo (NFS-e Paulistana).
Toda nota fiscal gerada deve ser rastreável no banco, com status claro.
Este projeto não possui interface pública nem painel administrativo neste momento.
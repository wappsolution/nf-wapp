<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Resultado da Simulação NFS-e</title>
    <style type="text/css">
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f4f4f4; color: #333; }
        .container { background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h1 { color: #0056b3; }
        h2 { color: #007bff; border-bottom: 1px solid #eee; padding-bottom: 5px; margin-top: 20px; }
        pre { background-color: #e9e9e9; padding: 15px; border-radius: 5px; overflow-x: auto; }
        .json-output, .xml-output { color: #000; }
        .copy-button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9em;
            margin-left: 10px;
        }
        .copy-button:hover {
            background-color: #0056b3;
        }
        .button {
            display: inline-block;
            padding: 8px 12px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 0.9em;
        }
        .button:hover {
            background-color: #218838;
        }
        .back-button {
            background-color: #6c757d;
        }
        .back-button:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Resultado da Simulação NFS-e</h1>

    <h2>Dados da Resposta (JSON) <button class="copy-button" onclick="copyToClipboard('jsonOutput')">Copiar JSON</button></h2>
    <pre id="jsonOutput" class="json-output"><?php echo json_encode($resultado, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?></pre>

    <?php if (isset($resultado['xml_enviado'])): ?>
        <h2>XML Enviado <button class="copy-button" onclick="copyToClipboard('xmlOutput')">Copiar XML</button></h2>
        <pre id="xmlOutput" class="xml-output"><?php echo htmlspecialchars($resultado['xml_enviado']); ?></pre>
    <?php endif; ?>

    <?php if (isset($validacao_xsd)): ?>
        <h2>Validação XSD <button class="copy-button" onclick="copyToClipboard('xsdOutput')">Copiar Validação XSD</button></h2>
        <pre id="xsdOutput" class="xsd-output">
            <?php if ($validacao_xsd['valid']): ?>
                XML Válido contra o XSD.
            <?php else: ?>
                XML INVÁLIDO contra o XSD. Erros:
                <?php foreach ($validacao_xsd['errors'] as $error): ?>
                    - <?php echo htmlspecialchars($error); ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </pre>
    <?php endif; ?>

    
    <p><a href="<?php echo site_url(); ?>" class="button back-button">Voltar para a página inicial</a></p>
    <p><a href="<?php echo site_url('nfse/listar_notas'); ?>" class="button back-button">Voltar para a Lista de Notas</a></p>
    <p><a href="<?php echo site_url('test'); ?>" class="button back-button">Voltar para o Menu de Testes</a></p>
</div>

<script>
// AIDEV-GENERATED: Função JavaScript para copiar texto para a área de transferência.
function copyToClipboard(elementId) {
    const element = document.getElementById(elementId);
    if (element) {
        const textToCopy = element.textContent || element.innerText;
        navigator.clipboard.writeText(textToCopy).then(() => {
            alert('Conteúdo copiado para a área de transferência!');
        }).catch(err => {
            console.error('Erro ao copiar: ', err);
            alert('Falha ao copiar o conteúdo.');
        });
    }
}
</script>

</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>Resultado do Teste</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { color: #333; }
        pre { background-color: #f0f0f0; padding: 15px; border: 1px solid #ccc; }
        .button {
            display: inline-block;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .button:hover { background-color: #0056b3; }
    </style>
</head>
<body>
    <h1>Resultado do Teste</h1>
    <pre><?php print_r($resultado); ?></pre>
    <a href="<?php echo site_url('test'); ?>" class="button">Voltar para o Menu de Testes</a>
</body>
</html>

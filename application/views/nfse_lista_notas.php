<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Lista de Notas Fiscais</title>
    <style type="text/css">
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f4f4f4; color: #333; }
        .container { background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h1 { color: #0056b3; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #007bff; color: white; }
        .button {
            display: inline-block;
            padding: 8px 12px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 0.9em;
        }
        .button:hover { background-color: #218838; }
        .back-button {
            background-color: #6c757d;
        }
        .back-button:hover {
            background-color: #5a6268;
        }
        .delete-button {
            background-color: #dc3545;
        }
        .delete-button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Notas Fiscais Salvas</h1>

    <p>
        <a href="<?php echo site_url('nfse/simular'); ?>" class="button">Simular Envio de NFS-e (Com CNPJ)</a>
        <a href="<?php echo site_url('nfse/simular_sem_cnpj'); ?>" class="button back-button">Simular Envio de NFS-e (Sem CNPJ)</a>
    </p>

    <?php if (empty($notas)): ?>
        <p>Nenhuma nota fiscal encontrada no banco de dados.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>CNPJ Remetente</th>
                    <th>Número RPS</th>
                    <th>Valor Serviços</th>
                    <th>Data Emissão</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($notas as $nota): ?>
                    <tr>
                        <td><?php echo $nota['id']; ?></td>
                        <td><?php echo $nota['cnpj_remetente']; ?></td>
                        <td><?php echo $nota['numero_rps']; ?></td>
                        <td><?php echo $nota['valor_servicos']; ?></td>
                        <td><?php echo $nota['data_emissao']; ?></td>
                        <td>
                            <a href="<?php echo site_url('nfse/gerar_xml_nota/' . $nota['id']); ?>" class="button">Gerar XML</a>
                            <a href="<?php echo site_url('nfse/excluir_nota/' . $nota['id']); ?>" class="button delete-button" onclick="return confirm('Tem certeza que deseja excluir esta nota fiscal?');">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <p>
        <a href="<?php echo site_url(); ?>" class="button back-button">Voltar para a Página Inicial</a>
    </p>
</div>

</body>
</html>

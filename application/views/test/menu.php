<!DOCTYPE html>
<html>
<head>
    <title>Testes do Projeto NFS-e</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { color: #333; }
        ul { list-style-type: none; padding: 0; }
        li { margin-bottom: 10px; }
        a {
            display: inline-block;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        a:hover { background-color: #0056b3; }
    </style>
</head>
<body>
    <h1>Menu de Testes</h1>
    <ul>
        <?php foreach ($testes as $teste): ?>
            <li><a href="<?php echo site_url('test/' . $teste['metodo']); ?>"><?php echo $teste['label']; ?></a></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>

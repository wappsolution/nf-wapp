<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Bem-vindo ao Conector NFS-e</title>

	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
		text-decoration: none;
	}

	a:hover {
		color: #97310e;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body {
		margin: 0 15px 0 15px;
	}

	p.footer {
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}

	#container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
	}

	.button-container {
		text-align: center;
		margin-top: 20px;
	}

	.button {
		display: inline-block;
		padding: 10px 20px;
		margin: 10px;
		background-color: #007bff;
		color: white;
		text-decoration: none;
		border-radius: 5px;
		font-size: 1.1em;
		transition: background-color 0.3s ease;
	}

	.button:hover {
		background-color: #0056b3;
	}

	.button.green {
		background-color: #28a745;
	}

	.button.green:hover {
		background-color: #218838;
	}

	.button.gray {
		background-color: #6c757d;
	}

	.button.gray:hover {
		background-color: #5a6268;
	}
	</style>
</head>
<body>

<div id="container">
	<h1>Bem-vindo ao Conector NFS-e!</h1>

	<div id="body">
		<p>Esta é a página inicial do seu projeto de integração de Notas Fiscais de Serviço Eletrônicas (NFS-e) com a Prefeitura de São Paulo.</p>

		<div class="button-container">
			<a href="<?php echo site_url('nfse/listar_notas'); ?>" class="button green">Listar Notas Fiscais</a>
			<a href="<?php echo site_url('test'); ?>" class="button">Menu de Testes</a>
		</div>

		<p>Para mais informações sobre o projeto, consulte o arquivo <code>GEMINI.md</code> na raiz do projeto.</p>
	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>

</body>
</html>

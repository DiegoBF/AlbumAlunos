<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Atividade Aberta 5</title>
<link rel="stylesheet" href="css/estilo.css">
<link rel="stylesheet" href="css/estiloLista.css">
<?php echo (!empty($headComplementar) ? $headComplementar : '');?>
</head>
<body>
	<header>
		<h1>Atividade Aberta 05 - &Aacute;lbum</h1>
		<?php echo (!empty($headerComplementar) ? '<h2>'.$headerComplementar.'</h2>' : ''); ?>
	</header>

	<nav>
		<ul>
			<li><a class="<?php echo (!empty($pagina) && $pagina == 'index.php' ? 'ativo' : '')?>" href="index.php">Principal</a></li>
			<li><a class="<?php echo (!empty($pagina) && $pagina == 'cadastrar.php' ? 'ativo' : '')?>" href="cadastrar.php">Cadastrar</a></li>
			<?php
				if (session_status() !== PHP_SESSION_ACTIVE) {
					session_start();
				}
				if(isset($_SESSION['auth']) && ($_SESSION['auth'] == true)){
					echo "<li><a class=\"". (!empty($pagina) && $pagina == 'editar.php' ? 'ativo' : '') ."\" href=\"editar.php\">Edi&ccedil;&atilde;o do Perfil</a></li> ";
					echo "<li><a href=\"excluir.php\">Excluir Perfil</a></li> ";
					echo "<li><a href=\"logout.php\">Sair</a></li>"; 
				} else {
					echo "<li><a href=\"login.php\">Login</a></li>";
				}  
			?>
		</ul>
	</nav>
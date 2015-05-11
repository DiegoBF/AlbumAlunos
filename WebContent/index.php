<?php
	$pagina = 'index.php';
	include_once("modelos/cabecalho.php");
	require_once("../conf/confBD.php");
	$conexao = conn_mysql();
	
	$strQuery = 'select login, nomeCompleto, arquivoFoto from participantes ';
	if (!empty($_SESSION['auth']) && ($_SESSION['auth']==true && !empty($_GET['filtroParticipante']))) {
		$strQuery .= 'where nomeCompleto like ? ';
	}
	$strQuery .= 'order by nomeCompleto';
	
	$operacaoSQLParticipantes = $conexao->prepare($strQuery);
	if (!empty($_GET['filtroParticipante'])) {
		$filtro = utf8_encode(htmlspecialchars($_GET['filtroParticipante']));
		$filtro = '%'.$filtro.'%';
		$pesquisarParticipantes = $operacaoSQLParticipantes->execute(array($filtro));
	} else {
		$pesquisarParticipantes = $operacaoSQLParticipantes->execute();
	}
	
	$listaParticipantes = $operacaoSQLParticipantes->fetchAll();
	
	$conexao = null;
?>
	
	<section id="apresentacao">
		<h2>Apresentação</h2>
		Este site &eacute; um &Aacute;lbum (<i>Yearbooks </i>) dos alunos do curso Desenvolvimento de Aplica&ccedil;&otilde;es Web.
		Para visuliazar detalhes de cada um dos alunos faz necess&aacute;rio estar autenticado no site.
	</section>
	
	<?php include_once("buscarParticipantes.php"); ?>
	
	<section id="listaPessoas">
		<h2>Lista</h2>
		<ul>
			<?php
				if (count($listaParticipantes) > 0) {
					foreach ($listaParticipantes as $participante) {
						echo '<li>';
						echo "<a href=\"paginaPessoal.php?id=".$participante['login']."\">";
						echo '<figure>';
						echo "<img src=\"fotosParticipantes/".$participante['arquivoFoto']."\" alt=\"".$participante['nomeCompleto']."\">";
						echo "<figcaption>".$participante['nomeCompleto']."</figcaption>";
						echo '</figure>';
						echo '</a>';
						echo '</li>';
					}
				} else {
					echo '<li>Nenhum participante cadastrado.</li>';
				}
			?>
		</ul>
	</section>
<?php
	include_once("modelos/rodape.html"); 
?>
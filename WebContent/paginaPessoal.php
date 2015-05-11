<?php
	require_once("verificarUsuarioLogado.php");
	require_once("../conf/confBD.php");

	$conexao = conn_mysql();
	$strQuery = 'select p.nomeCompleto, p.arquivoFoto, c.nomeCidade, e.siglaEstado, p.email, p.descricao ';
	$strQuery .= 'from participantes p ';
	$strQuery .= 'inner join cidades c on (c.idCidade = p.cidade) ';
	$strQuery .= 'inner join estados e on (e.idEstado = c.idEstado) ';
	$strQuery .= 'where login = ? ';
	$strQuery .= 'order by nomeCompleto';
	$operacaoSQLParticipante = $conexao->prepare($strQuery);
	$pesquisarParticipantes = $operacaoSQLParticipante->execute(array($_GET['id']));
	$participante = $operacaoSQLParticipante->fetchAll();
	$conexao = null;
	
	$headerComplementar = 'Perfil - '. utf8_encode(htmlspecialchars($participante[0]['nomeCompleto']));
	$headComplementar = "<link rel=\"stylesheet\" href=\"css/estiloPerfil.css\">";
	include_once("modelos/cabecalho.php");
?>
	<section id="perfil">
		<figure>
			<?php echo "<img src=\"fotosParticipantes/".$participante[0]['arquivoFoto']."\" alt=\"".$participante[0]['nomeCompleto']."\">"; ?>
			<figcaption>
				<ul>
					<li><em>Cidade:</em> <?php echo utf8_encode(htmlspecialchars($participante[0]['nomeCidade'])) . ' / '. utf8_encode(htmlspecialchars($participante[0]['siglaEstado'])); ?></li>
					<li><em>Email:</em> <?php echo utf8_encode(htmlspecialchars($participante[0]['email'])); ?> </li>
				</ul>
				<dl>
					<dt><em>Descri&ccedil;&atilde;o Pessoal</em></dt>
					<dd><?php echo utf8_encode(htmlspecialchars($participante[0]['descricao'])); ?></dd>
				</dl>
			</figcaption>
		</figure>
	</section>
<?php
	include_once("modelos/rodape.html"); 
?>
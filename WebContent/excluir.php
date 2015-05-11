<?php
require_once ("verificarUsuarioLogado.php");
require_once ("../conf/confBD.php");
try {
	$conexao = conn_mysql();
	
	$loginUsuarioLogado = utf8_encode(htmlspecialchars($_SESSION['nomeUsuario']));
	$SQLSelect = 'SELECT * FROM participantes WHERE login = ?';
	$operacao = $conexao->prepare($SQLSelect);
	$pesquisar = $operacao->execute(array($loginUsuarioLogado));
	$participante = $operacao->fetchAll();
	
	$SQLDelete = 'DELETE FROM participantes WHERE login = ?';
	$operacao = $conexao->prepare( $SQLDelete );
	$excluido = $operacao->execute(array($loginUsuarioLogado));
	$conexao = null;
	
	if ($excluido) {
		unlink("fotosParticipantes/".$participante[0]['arquivoFoto']);
		header("Location: logout.php");
	} else {
		echo "<h1>Erro na operação.</h1>\n";
		$arr = utf8_decode ( $operacao->errorInfo () );
		echo "<p>$arr[2]</p>";
		echo "<p><a href=\"index.php\">Retornar</a></p>\n";
	}
} catch ( PDOException $e ) {
	// caso ocorra uma exceção, exibe na tela
	echo "Erro!: " . $e->getMessage () . "<br>";
	die ();
}

?>
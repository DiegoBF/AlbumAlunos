<?php
require_once("../conf/confBD.php");
$pagina = 'cadastrar.php';
include_once("modelos/cabecalho.php");
try {
	$permissoes = array("gif", "jpeg", "jpg", "png", "image/gif", "image/jpeg", "image/jpg", "image/png");
	$temp_nomeArquivo = explode(".", basename($_FILES["foto"]["name"]));
	$extensao = end($temp_nomeArquivo);
	if ((in_array ( $extensao, $permissoes )) 
			&& (in_array ( $_FILES ["foto"] ["type"], $permissoes )) 
			&& ($_FILES ["foto"] ["size"] < $_POST ["TAMANHO_MAXIMO"])) {
		if ($_FILES["foto"]["error"] > 0) {
			echo "<h1>Erro no envio, código: " . $_FILES["foto"]["error"] . "</h1>";
		}
		else {
			$dirUploads = "fotosParticipantes/";
			$login = utf8_encode(htmlspecialchars($_POST['login']));
			
			if(!file_exists ( $dirUploads )) {
				mkdir($dirUploads, 0500);
			}
			
			$arquivoFoto = $login.'.'.$extensao;
			$caminhoArquivoFoto = $dirUploads.$arquivoFoto;
			
			if(move_uploaded_file($_FILES["foto"]["tmp_name"], $caminhoArquivoFoto)) {
				$senha = utf8_encode(htmlspecialchars($_POST['senha']));
				$nomeCompleto = utf8_encode(htmlspecialchars($_POST['nomeCompleto']));
				$cidade = $_POST['cidade'];
				$email = utf8_encode(htmlspecialchars($_POST['email']));
				$descricaoPessoal = utf8_encode(htmlspecialchars($_POST['descricaoPessoal']));
					
				$SQLInsert =  "INSERT INTO participantes(login, senha, nomeCompleto, arquivoFoto, cidade, email, descricao)";
				$SQLInsert .=                   "VALUES (?,md5(?),?,?,?,?,?)";
				
				$conexao = conn_mysql();
				$operacao = $conexao->prepare($SQLInsert);
				$inserido = $operacao->execute(array($login, $senha, $nomeCompleto, $arquivoFoto, $cidade, $email, $descricaoPessoal));
				$conexao = null;
				if ($inserido){
					echo'<div>';
					echo "<h3>Cadastro efetuado com sucesso.</h3>\n";
					echo'</div>';
				} else {
					echo "<h1>Erro na operação.</h1>\n";
					$arr = utf8_decode($operacao->errorInfo());		
					echo "<p>$arr[2]</p>";
					echo "<p><a href=\"cadastrar.php\">Retornar</a></p>\n";
				}
			} else {
				echo "<h1>Problemas ao armazenar a foto do participante. Tente novamente.<h1>";
			}
		}
	} else {
	  	echo "<h1>Arquivo inválido<h1>";
	}
} catch (PDOException $e) {
    // caso ocorra uma exceção, exibe na tela
    echo "Erro!: " . $e->getMessage() . "<br>";
    die();
}

include_once("modelos/rodape.html");
?>
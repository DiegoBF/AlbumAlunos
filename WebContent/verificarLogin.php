<?php
session_start();
	
	require_once("../conf/confBD.php");
	
      if(isset($_POST["login"])){
            $log = utf8_encode(htmlspecialchars($_POST["login"]));
            $senha = utf8_encode(htmlspecialchars($_POST["passwd"]));
			if(isset($_POST["lembrarLogin"]))
				$lembrar = utf8_encode(htmlspecialchars($_POST["lembrarLogin"]));
			else 
			    $lembrar="";
         
      }
      elseif(isset($_COOKIE["loginAutomatico"])){
            $log = utf8_encode(htmlspecialchars($_COOKIE["loginAlbum"]));
            $senha = utf8_encode(htmlspecialchars($_COOKIE["loginAutomatico"]));
		   }
        else{
	  	       header("Location:./erroLogin.php");
               die();
		}         
 try{
		$conexao = conn_mysql();
		$SQLSelect = 'SELECT * FROM participantes WHERE senha=MD5(?) AND login=?';
		$operacao = $conexao->prepare($SQLSelect);					  
		$pesquisar = $operacao->execute(array($senha, $log));
		$resultados = $operacao->fetchAll();
		$conexao = null;
		if (count($resultados)!=1){	
			header("Location:./erroLogin.php");
            die();
		}   
		else{
			setcookie("loginAlbum", $log, time()+60*60*24*10);
			if(!empty($lembrar)){
 			    setcookie("loginAutomatico", $senha, time()+60*60*24*10);	
			}
		   $_SESSION['auth']=true;
		   $_SESSION['nomeCompleto'] = $resultados[0]['nomeCompleto'];
		   $_SESSION['nomeUsuario'] = $log;
		   header("Location: index.php");
		   die();
		}
	} //try
	catch (PDOException $e)
	{
		// caso ocorra uma exceção, exibe na tela
		echo "Erro!: " . $e->getMessage() . "<br>";
		die();
	}
?>
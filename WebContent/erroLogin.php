<?php
setcookie("loginAlbum", '', time()-42000); 
setcookie("loginAutomatico", '', time()-42000); 

include_once("modelos/cabecalho_login.html");

?>

    <div class="container">

      <div>
        <h1>Não foi possível realizar o login.</h1>
		<p class="lead"><a href="index.php">Ir para p&aacute;gina principal.</a></p>
		<p class="lead"><a href="login.php">Ir para tela de login.</a></p>
	 </div> 
    </div><!-- /.container -->
<?php
include_once("modelos/rodape_login.html");
?>
<?php

if(isset($_COOKIE['loginAutomatico'])){
   header("Location: verificarLogin.php");
}
else if(isset($_COOKIE['loginAlbum']))
	$nomeUser = $_COOKIE['loginAlbum'];
	else $nomeUser="";
	
include_once("modelos/cabecalho_login.html");
?>

    <div class="container">

      <div class="starter-template">
        <form class="form-signin" method="post" action="./verificarLogin.php">
        <h3 class="form-signin-heading">Atividade Aberta 05 Álbum - Login</h3>
        <input type="text" class="form-control" placeholder="Login" name="login" value="<?php echo $nomeUser?>"required autofocus>
        <input type="password" class="form-control" placeholder="Senha" name="passwd" required>
        <label>
          <input type="checkbox"  name="lembrarLogin" value="loginAutomatico"> Permanecer conectado
        </label>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>
        <button class="btn btn-lg btn-primary btn-block" formaction="index.php" formnovalidate="formnovalidate">Página Principal</button>
      </form>
      </div>

    </div><!-- /.container -->

<?php
include_once("modelos/rodape_login.html");
?>
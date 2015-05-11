<?php
 function conn_mysql(){

   $servidor = 'localhost';
   $porta = 3306;
   $banco = "daw_yearbook";
   $usuario = "daw";
   $senha = "AlbumAluno2014";
   
      $conn = new PDO("mysql:host=$servidor;
	                   port=$porta;
					   dbname=$banco", 
					   $usuario, 
					   $senha,
					   array(PDO::ATTR_PERSISTENT => true)
					   );
      return $conn;
   }
?>
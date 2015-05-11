<?php
	$pagina = 'cadastrar.php';
	include_once("modelos/cabecalho.php");
	require_once("../conf/confBD.php");
	$conexao = conn_mysql();
	
	$operacaoSQLEstado = $conexao->prepare('select * from estados order by nomeEstado');
	$pesquisarEstado = $operacaoSQLEstado->execute();
	$listaEstados = $operacaoSQLEstado->fetchAll();
	
	$listaCidades = array();
	$estadoInformado = -1;
	if (isset($_POST["estado"])) {
		$estadoInformado = $_POST["estado"];
		$operacaoSQLCidade = $conexao->prepare('select * from cidades where idEstado='.$estadoInformado);
		$pesquisarCidade = $operacaoSQLCidade->execute();
		$listaCidades = $operacaoSQLCidade->fetchAll();
	}
	
	$conexao = null;
	
	$loginInformado = isset($_POST["login"]) ? $_POST["login"] : '';
	$nomeCompletoInformado = isset($_POST["nomeCompleto"]) ? $_POST["nomeCompleto"] : '';
	$emailInformado = isset($_POST["email"]) ? $_POST["email"] : '';
	$descricaoPessoalInformado = isset($_POST["descricaoPessoal"]) ? $_POST["descricaoPessoal"] : '';
?>

<div class="container">
	<fieldset>
	<legend>Novo Participante</legend>
		<form  method="post" action="cadastrarParticipante.php" enctype="multipart/form-data">
			<input type="hidden" name="TAMANHO_MAXIMO" value="500000" >
			<div>
				<label class="label" for="login">Login</label> 
				<input name="login" required="required" value="<?php echo $loginInformado ?>"/>
			</div>
			
			<div>
				<label class="label" for="senha">Senha</label> 
				<input type="password" name="senha" required="required" />
			</div>
			
			<div>
				<label for="foto">Escolha uma foto</label>
				<input type="file" name="foto" id="foto" placeholder="Escolha uma foto" required="required" />			
			</div>
			
			<div>
				<label class="label" for="nomeCompleto">Nome Completo</label> 
				<input name="nomeCompleto" size="50" required="required" value="<?php echo $nomeCompletoInformado ?>"/>
			</div>
		
			<div>
				<label class="label" for="estado">Estado</label> 
				<select name="estado">
					<?php
					foreach($listaEstados as $estado){
						echo "<option ";
						if ($estadoInformado == $estado["idEstado"]) {
							echo "selected ";
						}
						echo "value=\"".$estado["idEstado"]."\">";
						echo $estado["siglaEstado"].'-'.utf8_decode($estado["nomeEstado"]);
						echo "</option>\n";
					}			
					?>
				</select>
				<button formnovalidate="formnovalidate" formaction="cadastrar.php">Buscar Cidades</button>
			</div>
			
			<div>
				<label class="label" for="cidade">Cidade</label> 
				<select name="cidade" required="required">
					<?php
						if(count($listaCidades) > 0) {
							foreach($listaCidades as $cidade){
								echo "<option ";
								echo "value=\"".$cidade["idCidade"]."\">";
								echo utf8_decode($cidade["nomeCidade"]);
								echo "</option>\n";
							}
						} else {
							echo "<option value=\"\">Nenhuma cidade encontrada</option>";
						}
					?>
				</select>
			</div>			
			
			<div>
				<label class="label" for="email">Email</label> 
				<input type="email" name="email" size="50" required="required" value="<?php echo $emailInformado ?>"/>
			</div>
			
			<div>
				<label class="label" for="descricaoPessoal">Descri&ccedil;&atilde;o Pessoal </label>
				<textarea cols="39" rows="5" maxlength="500" name="descricaoPessoal" required="required"><?php echo $descricaoPessoalInformado ?></textarea>
			</div>  
			<button type="submit" class="btn btn-default">Cadastrar</button>
		</form>
	</fieldset>
</div>

<?php
	include_once("modelos/rodape.html");
?>
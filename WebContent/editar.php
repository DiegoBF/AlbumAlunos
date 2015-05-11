<?php
	require_once("verificarUsuarioLogado.php");
	$pagina = 'editar.php';
	include_once("modelos/cabecalho.php");
	require_once("../conf/confBD.php");
	$conexao = conn_mysql();
	
	$nomeCompletoInformado = '';
	$emailInformado = '';
	$descricaoPessoalInformado = '';
	$estadoInformado = -1;
	$cidadeInformado = -1;
	
	$operacaoSQLEstado = $conexao->prepare('select * from estados order by nomeEstado');
	$pesquisarEstado = $operacaoSQLEstado->execute();
	$listaEstados = $operacaoSQLEstado->fetchAll();
	
	if (empty($_POST['inicioEdicao'])) {
		$loginUsuarioLogado = utf8_encode(htmlspecialchars($_SESSION['nomeUsuario']));
		$SQLSelect = 'SELECT * FROM participantes WHERE login = ?';
		$operacao = $conexao->prepare($SQLSelect);
		$pesquisar = $operacao->execute(array($loginUsuarioLogado));
		$resultados = $operacao->fetchAll();
		
		$nomeCompletoInformado = utf8_encode(htmlspecialchars($resultados[0]['nomeCompleto']));
		$emailInformado = utf8_encode(htmlspecialchars($resultados[0]['email']));
		$descricaoPessoalInformado = utf8_encode(htmlspecialchars($resultados[0]['descricao']));
		
		$cidadeInformado = $resultados[0]['cidade'];
		
		$operacaoSQLCidadeEdicao = $conexao->prepare('select idEstado from cidades where idCidade='.$cidadeInformado);
		$pesquisarCidadeEdicao = $operacaoSQLCidadeEdicao->execute();
		$cidadeEdicao = $operacaoSQLCidadeEdicao->fetchAll();
		
		$estadoInformado = $cidadeEdicao[0]["idEstado"];
	} else {
		$nomeCompletoInformado = isset($_POST["nomeCompleto"]) ? $_POST["nomeCompleto"] : '';
		$emailInformado = isset($_POST["email"]) ? $_POST["email"] : '';
		$descricaoPessoalInformado = isset($_POST["descricaoPessoal"]) ? $_POST["descricaoPessoal"] : '';
		if (isset($_POST["estado"])) {
			$estadoInformado = $_POST["estado"];
		}
	}
	
	$operacaoSQLCidade = $conexao->prepare('select * from cidades where idEstado='.$estadoInformado);
	$pesquisarCidade = $operacaoSQLCidade->execute();
	$listaCidades = $operacaoSQLCidade->fetchAll();
	$conexao = null;
?>

<div class="container">
	<fieldset>
	<legend>Editar Dados do Participante</legend>
		<form  method="post" action="editarParticipante.php" enctype="multipart/form-data">
			<input type="hidden" name="TAMANHO_MAXIMO" value="500000" >
			<input type="hidden" name="inicioEdicao" value="true" >
			<div>
				<label class="label" for="login">Login</label>
				<?php echo $_SESSION['nomeUsuario'] ?>
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
				<button formnovalidate="formnovalidate" formaction="editar.php">Buscar Cidades</button>
			</div>
			
			<div>
				<label class="label" for="cidade">Cidade</label> 
				<select name="cidade" required="required">
					<?php
						if(count($listaCidades) > 0) {
							foreach($listaCidades as $cidade){
								echo "<option ";
								if ($cidadeInformado == $cidade["idCidade"]) {
									echo "selected ";
								}
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
			<button type="submit" class="btn btn-default">Alterar</button>
		</form>
	</fieldset>
</div>

<?php
	include_once("modelos/rodape.html");
?>
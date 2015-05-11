<?php
	if(!empty($_SESSION['auth']) && ($_SESSION['auth']==true)){ 
?>
		<section id="buscasParticipantes">
			<form action="index.php" method="get">
				<div style="margin: 10px">
					<label class="label" for="filtroParticipante">Filtro:</label> 
					<input name="filtroParticipante" />
					<button type="submit" class="btn btn-default">Filtrar</button>
				</div>
			</form>
		</section>
<?php
	} 
?>
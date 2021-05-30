<html>
<head>
	<title>Inserisci Camere</title>
</head>
<body>
<?php

if (!array_key_exists("HTTP_REFERER", $_SERVER)) {
	session_destroy();
	header("Location: http://localhost/Login/Agriturismo/hub.html");
} else {
	session_start();
	require '../agriturismo_connect.php';

	switch ($_SESSION['Tipo']) {
		case "Cliente":
			$urlportale = "../portale.php";
			break;
		case "Dipendente":
			$urlportale = "../portaledip.php";
			break;
		case "Amministratore":
			$urlportale = "../portaleadmin.php";
			break;
		default :
			$urlportale = "../hub.html";
			break;
	}

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$numero = $_POST['numero'];
		$prezzo = $_POST['prezzo'];
		$tipicamere = $_POST['tipicamere'];
		echo("Vuoi inserire davvero la camera numero $numero, prezzo $prezzo e tipo $tipicamere?");
		?>
		<form action="conf_insert_camere.php" method="post">
			<input type="submit" value="Inserisci">
			<input type="text" name="numero" value="<?= $numero ?>" hidden>
			<input type="text" name="prezzo" value="<?= $prezzo ?>" hidden>
			<input type="text" name="tipicamere" value="<?= $tipicamere ?>" hidden>
		</form>
		<?php
	} else {
		?>
		Inserisci una camera:<br>
		<form method="post" action="">
			<br>Numero:&nbsp;<input type="number" name="numero">
			<br>Prezzo:&nbsp;<input type="number" name="prezzo">
			<?php
			$querytipicamere = "SELECT * FROM TipiCamere";
			$querytipicamere_result = $conn->query($querytipicamere);
			if (!$querytipicamere_result) {
				echo("Errore nella query");
			} else {
				$row_tipicamere = $querytipicamere_result->fetch_array();
				?>
				<select name="tipicamere">
					<option value="-"> -</option>
					<?php
					while ($row_tipicamere != null) {
						?>
						<option value="<?= $row_tipicamere['idTipiCamere'] ?>"><?= $row_tipicamere['Nome'] ?> - <?= $row_tipicamere['MaxPersone'] ?> persone</option>
						<?php
						$row_tipicamere = $querytipicamere_result->fetch_array();
					}
					?>
				</select>
				<?php
			}
			?>
			<br><input type="submit" value="Inserisci"></form>
		<?php
	}
	?>
	<form action="<?= $urlportale ?>">
		Torna al portale&nbsp;<input type="submit" value="Vai">
	</form>
	<?php
}
?>
</body>
</html>

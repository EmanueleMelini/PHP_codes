<html>
<head>
	<title>Inserisci Attività Ippiche</title>
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
		$nome = $_POST['nome'];
		$orainizio = $_POST['orainizio'];
		$orafine = $_POST['orafine'];
		$prezzo = $_POST['prezzo'];
		echo("Vuoi inserire davvero l'attività ippica di nome $nome, ora d'inizio $orainizio, ora di fine $orafine e prezzo $prezzo euro?");
		?>
		<form action="conf_insert_attivitaippiche.php" method="post">
			<input type="submit" value="Inserisci">
			<input type="text" name="nome" value="<?= $nome ?>" hidden>
			<input type="text" name="orainizio" value="<?= $orainizio ?>" hidden>
			<input type="text" name="orafine" value="<?= $orafine ?>" hidden>
			<input type="text" name="prezzo" value="<?= $prezzo ?>" hidden>
		</form>
		<?php
	} else {
		?>
		Inserisci un'attività ippica:<br>
		<form method="post" action="">
			<br>Nome:&nbsp;<input type="text" name="nome">
			<br>Ora Inizio:&nbsp;<input type="time" name="orainizio">
			<br>Ora Fine:&nbsp;<input type="time" name="orafine">
			<br>Prezo:&nbsp;<input type="number" name="prezzo">
			<br><input type="submit" value="Inserisci">
		</form>
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
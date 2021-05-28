<html>
<head>
	<title>Inserisci Attività Ippica</title>
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

	$nome = $_POST['nome'];
    $orainizio = $_POST['orainizio'];
    $orafine = $_POST['orafine'];
    $prezzo = $_POST['prezzo'];

	$queryattivitaippicains = "INSERT INTO AttivitaIppiche(Nome, OraInizio, OraFine, Prezzo)
VALUES ('$nome', '$orainizio', '$orafine', '$prezzo')";
	$queryattivitaippicains_result = $conn->query($queryattivitaippicains);
	if (!$queryattivitaippicains_result) {
		echo("Errore nella query");
	} else {
		echo("Attività Ippica inserita correttamente");
	}
	?>
	<form action="insert_attivitaippiche.php">
		<br>Torna all'inserimento delle Attività Ippiche&nbsp;<input type="submit" value="Vai">
	</form>
	<form action="<?= $urlportale ?>">
		Torna al portale&nbsp;<input type="submit" value="Vai">
	</form>
	<?php
}
?>
</body>
</html>

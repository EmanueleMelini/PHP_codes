<html>
<head>
	<title>Cancellazione tutte Prenotazioni</title>
</head>
<body>
<?php
if (!array_key_exists("HTTP_REFERER", $_SERVER)) {
	header("Location: http://localhost/Login/Agriturismo/hub.html");
} else {
	require '../agriturismo_connect.php';
	session_start();

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
		$queryeliminaprenotazione = "UPDATE PrenSoggiorni SET Eliminato = 1 WHERE idCliente = '$_SESSION[idCliente]'";
		$queryeliminaprenotazione_result = $conn->query($queryeliminaprenotazione);
		if (!$queryeliminaprenotazione_result) {
			echo("Errore nella query");
		} else {
			echo("Prenotazione cancellata correttamente");
		}
	} else {
		?>
		<form action="" method="post">
			Vuoi cancellare davvero tutte le prenotazioni?&nbsp;<input type="submit" value="Elimina">
		</form>
		<?php
	}
	?>
	<form action="../Ristorante/visual_prenotazioni_cibi.php">
		Torna alla visualizzazione delle prenotazioni&nbsp;<input type="submit" value="Vai">
	</form>
	<form action="<?= $urlportale ?>">
		Torna al portale&nbsp;<input type="submit" value="Vai">
	</form>
	<?php
}
?>
</body>
</html>
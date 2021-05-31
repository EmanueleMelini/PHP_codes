<html>
<head>
	<title>Prenota Cibi</title>
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

	$listaid = $_POST['listaid'];
	$listaidarray = explode(",", $listaid);
	$orapren = $_POST['orapren'];
	$dataoggi = date("Y-m-d");
	$oraoggi = date("H:i");
	$tavolo = $_POST['tavolo'];
	$tipo = $_POST['tipo'];
	$f = true;
	for ($i = 0; $i < count($listaidarray); $i++) {
		if ($tipo == "pizze") {
			$queryprenotazione = "INSERT INTO PrenCibi(idPizza, idCLiente, DataP, OraP, Tavolo, OraC)
VALUES('$listaidarray[$i]', '$_SESSION[idCliente]', '$dataoggi', '$oraoggi', '$tavolo', '$orapren')";
		} else {
			$queryprenotazione = "INSERT INTO PrenCibi(idPiattoTipico, idCLiente, DataP, OraP, Tavolo, OraC)
VALUES('$listaidarray[$i]', '$_SESSION[idCliente]', '$dataoggi', '$oraoggi', '$tavolo', '$orapren')";
		}
		$queryprenotazione_result = $conn->query($queryprenotazione);
		if (!$queryprenotazione_result) {
			echo("Errore nella query $i");
			$f = false;
		}
	}
	if ($f)
		echo("Ordine prenotato correttamente");
	?>
	<form action="visual_prenotazioni_cibi.php">
		Visualizza prenotazioni&nbsp;<input type="submit" value="Vai">
	</form>
	<form action="<?= $urlportale ?>">
		Torna all'hub&nbsp;<input type="submit" value="Hub">
	</form>
	<?php
}
?>
</body>
</html>

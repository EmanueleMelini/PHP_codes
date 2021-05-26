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
$idprenattivitaippiche = $_POST['idprenattivitaippiche'];
$queryaccettaprenotazione = "UPDATE PrenAttivita SET Accettato = 1 WHERE idPrenAttivita = '$idprenattivitaippiche'";
$queryaccettaprenotazione_result = $conn->query($queryaccettaprenotazione);
if (!$queryaccettaprenotazione_result) {
	echo("Errore nella query");
} else {
	echo("Prenotazione cancellata correttamente");
}
?>
<html>
<head>
	<title>Accetta Prenotazione</title>
</head>
<body>
<form action="visual_prenotazioni_attivitaippiche.php">
	<br>Torna alla visualizzazione delle prenotazioni&nbsp;<input type="submit" value="Vai">
</form>
<form action="<?= $urlportale ?>">
	Torna al portale&nbsp;<input type="submit" value="Vai">
</form>
<?php
}
?>
</body>
</html>
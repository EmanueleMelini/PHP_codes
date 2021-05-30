<html>
<head>
	<title>Accetta Prenotazione</title>
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

$idprenescursioni = $_POST['idprenescursioni'];
$queryaccettaprenotazione = "UPDATE PrenEscursioni SET Accettato = 1 WHERE idPrenEscursioni = '$idprenescursioni'";
$queryaccettaprenotazione_result = $conn->query($queryaccettaprenotazione);
if (!$queryaccettaprenotazione_result) {
	echo("Errore nella query");
} else {
	echo("Prenotazione accettata correttamente");
}
?>
<form action="visual_prenotazioni_escursioni.php">
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
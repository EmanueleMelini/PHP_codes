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
$idprencibi = $_POST['idprencibi'];
$prezzo = $_POST['prezzo'];
$queryeliminaprenotazione = "UPDATE PrenCibi SET Eliminato = 1 WHERE idPrenCibi = '$idprencibi'";
$queryeliminaprenotazione_result = $conn->query($queryeliminaprenotazione);
if (!$queryeliminaprenotazione_result) {
	echo("Errore nella query");
} else {
	$_SESSION['totprezzo'] = $_SESSION['totprezzo'] - $prezzo;
	echo("Prenotazione cancellata correttamente");
}
?>
<html>
<head>
	<title>Cancellazione Prenotazione</title>
</head>
<body>
<form action="visual_prenotazioni_cibi.php">
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

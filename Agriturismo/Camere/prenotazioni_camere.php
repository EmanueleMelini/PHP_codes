<html>
<head>
	<title>Prenota Camere</title>
</head>
<body>
<?php
if (!array_key_exists("HTTP_REFERER", $_SERVER)) {
	header("Location: http://localhost/Login/Agriturismo/hub.html");
} else {
require '../agriturismo_connect.php';
session_start();

$idcamera = $_POST['idcamera'];
$querycamera = "SELECT * FROM Camere INNER JOIN TipiCamere ON Camere.idTipoCamera = TipICamere.idTipiCamere WHERE Camere.idCamere = '$idcamera'";
$querycamera_result = $conn->query($querycamera);
if (!$querycamera_result) {
	echo("Errore nella query");
} else {
	$row_camera = $querycamera_result->fetch_array();
	echo("Numero $row_camera[Numero] Prezzo $row_camera[Prezzo] Tipo $row_camera[Nome] Max Persone $row_camera[MaxPersone]<br><br>");
	$queryprencamere = "SELECT * FROM Camere INNER JOIN PrenSoggiorni ON Camere.idCamere = PrenSoggiorni.idCamera INNER JOIN TipiCamere ON Camere.idTipoCamera = TipiCamere.idTipiCamere where Camere.idCamere = '$idcamera'";
	$queryprencamere_result = $conn->query($queryprencamere);
	if (!$queryprencamere_result) {
		echo("Errore nella query");
	} else {
		if ($queryprencamere_result->num_rows == 0) {
			echo("Nessuna prenotazione per la camera selezionata");
		} else {
			$row_prencamere = $queryprencamere_result->fetch_array();
			while ($row_prencamere != null) {
				echo("Prenotata da $row_prencamere[DataInizio] a $row_prencamere[DataFine]<br>");
				$row_prencamere = $queryprencamere_result->fetch_array();
			}
		}
	}
}
?>

<br>
<form action="conf_prenotazioni_camere.php" method="post">
	<br>Data inizio prenotazione&nbsp;<input type="date" name="datainiziopren">
	<br>Data fine prenotazione&nbsp;<input type="date" name="datafinepren">
	<input type="text" name="idcamera" value="<?= $idcamera ?>" hidden>
	<br><input type="submit" value="Prenota">
</form>
<br><br>
<form action="visual_camere.php">
	Torna alla visualizzazione delle camere&nbsp;<input type="submit" value="Vai">
</form>
<form action="../portale.php">
	Torna al portale agriturismo&nbsp;<input type="submit" value="Vai">
</form>
</body>

<?php
}
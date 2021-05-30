<html>
<head>
	<title>Visualizza Vecchie Prenotazioni</title>
</head>
<body>
<?php
if (!array_key_exists("HTTP_REFERER", $_SERVER)) {
	header("Location: http://localhost/Login/Agriturismo/hub.html");
} else {
	require '../agriturismo_connect.php';
	session_start();

	$dataoggi = date("Y-m-d");
	$oraoggi = date("H:i");

	switch ($_SESSION['Tipo']) {
		case "Cliente":
			$utente = "Cliente";
			$urlportale = "../portale.php";
			break;
		case "Dipendente":
			$utente = "Dipendente";
			$urlportale = "../portaledip.php";
			break;
		case "Amministratore":
			$utente = "Amministratore";
			$urlportale = "../portaleadmin.php";
			break;
		default :
			$utente = "Errore";
			$urlportale = "../hub.html";
			break;
	}

	$queryoldprenotazioni = "SELECT idPrenSoggiorni, idCamere, Numero, idCliente, DataInizio, DataFine, Nome, Descrizione, Eliminato, Accettato, Prezzo 
FROM PrenSoggiorni INNER JOIN Camere ON PrenSoggiorni.idCamera = Camere.idCamere INNER JOIN Tipicamere ON Camere.idTipoCamera = TipiCamere.idTipiCamere
WHERE DataFine < '$dataoggi' AND idCliente = $_SESSION[idCliente]";

	$queryoldprenotazioni_result = $conn->query($queryoldprenotazioni);
	if (!$queryoldprenotazioni_result) {
		echo("Errore nella query");
	} else {
		?>
		Prenotazioni vecchie di <?= $_SESSION['Nome'] . " " . $_SESSION['Cognome'] ?><br><br>
		<?php
		if ($queryoldprenotazioni_result->num_rows == 0) {
			echo("<br>Nessuna prenotazione trovata");
		} else {
			$row_oldprenotazioni = $queryoldprenotazioni_result->fetch_array();
			?>
			<table border="1">
				<?php
				while ($row_oldprenotazioni != null) {
					?>
					<tr>
						<td>Numero Camere: <?= $row_oldprenotazioni['Numero'] ?></td>
						<td>Data Inizio: <?= $row_oldprenotazioni['DataInizio'] ?></td>
						<td>Data Fine: <?= $row_oldprenotazioni['DataFine'] ?></td>
						<td>Prezzo: <?= $row_oldprenotazioni['Prezzo'] ?></td>
						<td>Tipo Camera: <?= $row_oldprenotazioni['Nome'] . " " . $row_oldprenotazioni['Descrizione'] ?></td>
						<td>Data Prenotazione: <?= $row_oldprenotazioni['DataA'] ?></td>
					</tr>
					<?php
					$row_oldprenotazioni = $queryoldprenotazioni_result->fetch_array();
				}
				?>
			</table>
			<?php
		}
	}
	?>
	<br>
	<form action="visual_prenotazioni_soggiorni.php">
		Visualizza prenotazioni&nbsp;<input type="submit" value="Vai">
	</form>
	<form action="<?= $urlportale ?>">
		Torna al portale&nbsp;<input type="submit" value="Vai">
	</form>
	<?php
}
?>
</body>
</html>
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

	$queryoldprenotazioni = "SELECT idPrenEscursioni, idEscursioni, idCliente, DataE, idGuida, Escursioni.Nome as NomeEs, Dipendenti.Nome, Cognome, Eliminato, Accettato, Prezzo
FROM PrenEscursioni INNER JOIN Escursioni ON PrenEscursioni.idEscursione = Escursioni.idEscursioni INNER JOIN Dipendenti ON PrenEscursioni.idGuida = Dipendenti.idDipendenti
WHERE (Eliminato = 1 OR (DataE < '$dataoggi' AND Accettato = 1)) AND idCliente = $_SESSION[idCliente]";

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
						<td>Nome Escursione: <?= $row_oldprenotazioni['NomeEs'] ?></td>
						<td>Prezzo: <?= $row_oldprenotazioni['Prezzo'] ?></td>
						<td>guida: <?= $row_oldprenotazioni['Nome'] . " " . $row_oldprenotazioni['Cognome'] ?></td>
						<td>Data Prenotazione: <?= $row_oldprenotazioni['DataE'] ?></td>
						<?php
						if ($row_oldprenotazioni['Eliminato'] == 1) {
							?>
							<td>Prenotazione Cancellata</td>
							<?php
						} else if ($row_oldprenotazioni['Accettato'] == 1) {
							?>
							<td>Prenotazione Accettata</td>
							<?php
						}
						?>
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
	<form action="visual_prenotazioni_escursioni.php">
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
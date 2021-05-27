<html>
<head>
	<title>Attività Ippiche</title>
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

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$idattivitaippiche = $_POST['idattivitaippiche'];

		$querycancellaattivita = "DELETE FROM AttivitaIppiche WHERE idAttivitaIppiche = '$idattivitaippiche'";
		$querycancellaattivita_result = $conn->query($querycancellaattivita);
		if (!$querycancellaattivita_result) {
			echo("Errore nella query");
		} else {
			?>
			Attività Ippica cancellata correttamente <br>
			<form method="get" action="">
				Torna alla visualizzazione delle Attività Ippiche<input type="submit" value="Vai">
			</form>
			<form action="<?= $urlportale ?>">
				Torna al portale<input type="submit" value="Vai">
			</form>
			<?php
		}
	} else {
		$queryattivitaippiche = "SELECT * FROM AttivitaIppiche";
		$queryattivitaippiche_result = $conn->query($queryattivitaippiche);
		if ($queryattivitaippiche_result->num_rows == 0) {
			echo("Nessuna pizza nel menu");
		} else {
			?>
			<table border="1">
			<tr>
				<td>Nome Escursione</td>
				<td>Ora Inizio</td>
				<td>Ora Fine</td>
			</tr>
			<tr>
			<?php
			$row_menu = $queryattivitaippiche_result->fetch_array();
			while ($row_menu != null) {
				echo("<td>$row_menu[Nome]</td><td>$row_menu[OraInizio]</td><td>$row_menu[OraFine]</td>");
				if ($utente == "Amministratore") {
					?>
					<form method="post" action="">
						<td>
							<input type="submit" value="Cancella">
							<input type="text" name="idattivitaippiche" value="<?= $row_menu['idAttivitaIppiche'] ?>" hidden>
						</td>
					</form>
					<?php
				}
				echo("</tr>");
				$row_menu = $queryattivitaippiche_result->fetch_array();
			}
		}
		?>
		</table>
		<br><br>
		<form action="<?= $urlportale ?>">
			Torna al portale agriturismo&nbsp;<input type="submit" value="Vai">
		</form>
		<?php
	}
}
?>
</body>
</html>

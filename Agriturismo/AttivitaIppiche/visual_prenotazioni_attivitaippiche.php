<html>
<head>
	<title>Visualizza Prenotazioni</title>
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

	$queryeliminato = "UPDATE PrenAttivita SET Eliminato = 1 WHERE DataA < '$dataoggi' AND Accettato = 0";
	$queryeliminato_result = $conn->query($queryeliminato);
	if (!$queryeliminato_result) {
		echo("Errore nella query!");
	}

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
		$idprenattivitaippiche = $_POST['idprenattivitaippiche'];
		$nome = $_POST['nome'];
		?>
		<form action="cancella_prenotazione_attivitaippica.php" method="post">
			Vuoi cancellare davvero la prenotazione di: <?= $nome ?>?
			<input type="submit" value="Elimina">
			<input type="text" name="idprenattivitaippiche" value="<?= $idprenattivitaippiche ?>" hidden>
		</form>
		<?php
	} else {
		if ($utente == "Cliente") {
			$queryprenotazioni = "SELECT idPrenAttivita, idAttivita, idCliente, DataA, OraInizio, OraFine, idAddetto, AttivitaIppiche.Nome as Nomeatt, OraInizio, OraFine, Dipendenti.Nome, Cognome, Accettato, Prezzo
FROM PrenAttivita INNER JOIN AttivitaIppiche ON AttivitaIppiche.idAttivitaIppiche = PrenAttivita.idAttivita INNER JOIN Dipendenti Dipendenti.idDipendenti = PrenAttivita.idAddetto
WHERE DataA >= '$dataoggi' AND Eliminato = 0 AND idCliente = $_SESSION[idCliente]";
		} else {
			$queryprenotazioni = "SELECT idPrenAttivita, idAttivita, idCliente, DataA, OraInizio, OraFine, idAddetto, AttivitaIppiche.Nome as Nomeatt, OraInizio, OraFine, Dipendenti.Nome, Dipendenti.Cognome, Clienti.Nome as NomeC, Clienti.Cognome as CognomeC, Accettato, Prezzo
FROM PrenAttivita INNER JOIN AttivitaIppiche ON AttivitaIppiche.idAttivitaIppiche = PrenAttivita.idAttivita INNER JOIN Dipendenti ON Dipendenti.idDipendenti = PrenAttivita.idAddetto INNER JOIN Clienti ON PrenAttivita.idCLiente = Clienti.idCLienti
WHERE DataA >= '$dataoggi' AND Eliminato = 0";
		}
		$queryprenotazioni_result = $conn->query($queryprenotazioni);
		if (!$queryprenotazioni_result) {
			echo("Errore nella query");
		} else {
			$totprezzo = 0;
			if ($utente == "Cliente") {
				echo("Prenotazioni del cliente $_SESSION[Nome] $_SESSION[Cognome]<br><br>");
			} else if ($utente == "Dipendente") {
				echo("Dipendente $_SESSION[Nome] $_SESSION[Cognome]<br><br>");
			} else {
				echo("Amministratore $_SESSION[Nome] $_SESSION[Cognome]<br><br>");
			}
			if ($queryprenotazioni_result->num_rows === 0) {
				echo("Nessuna prenotazione attiva");
			} else {
				?>
				<table border="1">
					<?php
					$row_prenotazioni = $queryprenotazioni_result->fetch_array();
					while ($row_prenotazioni != null) {
						$totprezzo = $totprezzo + $row_prenotazioni['Prezzo'];
						?>
						<tr>
							<td>Nome Attivita: <?= $row_prenotazioni['Nomeatt'] ?></td>
							<td>Ora Inizio: <?= $row_prenotazioni['OraInizio'] ?></td>
							<td>Ora Fine: <?= $row_prenotazioni['OraFine'] ?></td>
							<td>Prezzo: <?= $row_prenotazioni['Prezzo'] ?></td>
							<td>Addetto: <?= $row_prenotazioni['Nome'] . " " . $row_prenotazioni['Cognome'] ?></td>
							<td>Data Prenotazione: <?= $row_prenotazioni['DataA'] ?></td>
							<?php
							if ($utente == "Dipendente" || $utente == "Amministratore") {
								?>
								<td>Cliente: <?= $row_prenotazioni['NomeC'] . " " . $row_prenotazioni['CognomeC'] ?></td>
								<?php
							}
							if ($utente == "Cliente" || $utente == "Amministratore") {
								if ($row_prenotazioni['Accettato'] == 0) {
									?>
									<form action="" method="post">
										<td>Cancella Prenotazione&nbsp;<input type="submit" value="Cancella"></td>
										<input type="text" name="idprenattivitaippiche" value="<?= $row_prenotazioni['idPrenAttivita'] ?>" hidden>
										<input type="text" name="nome" value="<?= $row_prenotazioni['Nomeatt'] ?>" hidden>
									</form>
									<?php
								} else {
									?>
									<td>Prenotazione Accettata</td>
									<?php
								}
							} else {
								if ($row_prenotazioni['Accettato'] == 0) {
									?>
									<form action="accetta_prenotazioni_attivitaippiche.php" method="post">
										<td>
											Accetta Prenotazione&nbsp;<input type="submit" value="Accetta">
											<input type="text" name="idprenattivitaippiche" value="<?= $row_prenotazioni['idPrenAttivita'] ?>" hidden>
										</td>
									</form>
									<?php
								} else {
									?>
									<td>Prenotazione Accettata&nbsp;<input type="submit" value="Accettata" disabled>
									</td>
									<?php
								}
							}
							?>
						</tr>
						<?php
						$row_prenotazioni = $queryprenotazioni_result->fetch_array();
					}
					?>
				</table>
				<?php
				if ($utente == "Cliente") {
					echo("<br>Per un totale di $totprezzo euro.");
				}
				?>
				<br><br>
				<form action="cancella_tutte_prenotazioni_attivitaippiche.php">
					Cancella tutte le prenotazioni&nbsp;<input type="submit" value="Cancella">
				</form>
				<?php
			}
		}
	}
	if ($utente == "Cliente") {
		?>
		<form action="visual_old_prenotazioni_attivitaippica.php">
			Visualizza vecchie prenotazioni&nbsp;<input type="submit" value="Vai">
		</form>
		<?php
	}
	?>
	<form action="<?= $urlportale ?>">
		Torna al portale&nbsp;<input type="submit" value="Vai">
	</form>
	<?php
}
?>
</body>
</html>
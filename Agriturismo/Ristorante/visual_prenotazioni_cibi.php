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

	$queryeliminato = "UPDATE PrenCibi SET Eliminato = 1 WHERE DataP < '$dataoggi'";
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
		$idprencibi = $_POST['idprencibi'];
		$nome = $_POST['nome'];
		$prezzo = $_POST['prezzo'];
		?>
		<form action="cancella_prenotazione_cibo.php" method="post">
			Vuoi cancellare davvero la prenotazione di: <?= $nome ?>?
			<input type="submit" value="Elimina">
			<input type="hidden" name="idprencibi" value="<?= $idprencibi ?>">
			<input type="hidden" name="prezzo" value="<?= $prezzo ?>">
		</form>
		<?php
	} else {
		if ($utente == "Cliente") {
			$queryprenotazioni = "select idPrenCibi, idCLiente, DataP, OraP, Tavolo, idPiattoTipico, piattitipici.Nome as NomeTipico, piattitipici.Prezzo as PrezzoTipico, idPizza, pizze.Nome as NomePizza, pizze.Prezzo as PrezzoPizza, Eliminato, Accettato
from (prencibi left outer join piattitipici on prencibi.idPiattoTipico = piattitipici.idPiattiTipici)
left outer join pizze on pizze.idPizze = prencibi.idPizza 
where Datap >= '$dataoggi' and OraC >= '$oraoggi' and Eliminato = 0 and idCliente = $_SESSION[idCliente]";
		} else {
			$queryprenotazioni = "select idPrenCibi, idCLiente, DataP, OraP, Tavolo, idPiattoTipico, piattitipici.Nome as NomeTipico, piattitipici.Prezzo as PrezzoTipico, idPizza, pizze.Nome as NomePizza, pizze.Prezzo as PrezzoPizza, Clienti.Nome as NomeC, Clienti.Cognome as CognomeC, Eliminato, Accettato
from (prencibi left outer join piattitipici on prencibi.idPiattoTipico = piattitipici.idPiattiTipici)
left outer join pizze on pizze.idPizze = prencibi.idPizza inner join Clienti on PrenCibi.idCLiente = Clienti.idCLienti
where Datap >= '$dataoggi' and OraC >= '$oraoggi' and Eliminato = 0";
		}
		$queryprenotazioni_result = $conn->query($queryprenotazioni);
		if (!$queryprenotazioni_result) {
			echo("Errore nella query");
		} else {
			$totprezzo = 0;
			if ($utente === "Cliente") {
				echo("Prenotazioni del cliente $_SESSION[Nome] $_SESSION[Cognome]<br><br>");
			} else if ($utente == "Dipendente") {
				echo("Dipendente $_SESSION[Nome] $_SESSION[Cognome]<br><br>");
			} else {
				echo("Amministratore $_SESSION[Nome] $_SESSION[Cognome]<br><br>");
			}
			if ($queryprenotazioni_result->num_rows === 0) {
				echo("Nessuna prenotazione attiva<br><br>");
			} else {
				?>
				<table border="1">
					<?php
					$row_prenotazioni = $queryprenotazioni_result->fetch_array();
					while ($row_prenotazioni != null) {
						?>
						<tr>
							<?php
							if ($row_prenotazioni['idPiattoTipico'] == null) {
								$totprezzo = $totprezzo + $row_prenotazioni['PrezzoPizza'];
								?>
								<td>Nome Pizza: <?= $row_prenotazioni['NomePizza'] ?></td>
								<td>Prezzo: <?= $row_prenotazioni['PrezzoPizza'] ?></td>
								<?php
							} else {
								$totprezzo = $totprezzo + $row_prenotazioni['PrezzoTipico'];
								?>
								<td>Nome Piatto Tipico: <?= $row_prenotazioni['NomeTipico'] ?></td>
								<td>Prezzo: <?= $row_prenotazioni['PrezzoTipico'] ?></td>
								<?php
							}
							?>
							<td>Data Prenotazione: <?= $row_prenotazioni['DataP'] ?></td>
							<td>Ora Prenotazione: <?= $row_prenotazioni['OraP'] ?></td>
							<td>Numero tavolo: <?= $row_prenotazioni['Tavolo'] ?></td>
							<?php
							if ($utente == "Dipendente") {
								?>
								<td>Cliente: <?= $row_prenotazioni['NomeC'] . " " . $row_prenotazioni['CognomeC'] ?></td>
								<?php
							}
							if ($utente == "Cliente" || $utente == "Amministratore") {
								if ($row_prenotazioni['Accettato'] == 0) {
									?>
									<form action="" method="post">
										<td>Cancella Prenotazione&nbsp;<input type="submit" value="Cancella"></td>
										<input type="text" name="idprencibi" value="<?= $row_prenotazioni['idPrenCibi'] ?>" hidden>
										<?php
										if ($row_prenotazioni['idPiattoTipico'] == null) {
											?>
											<input type="text" name="prezzo" value="<?= $row_prenotazioni['PrezzoPizza'] ?>" hidden>
											<input type="text" name="nome" value="<?= $row_prenotazioni['NomePizza'] ?>" hidden>
											<?php
										} else {
											?>
											<input type="text" name="prezzo" value="<?= $row_prenotazioni['PrezzoTipico'] ?>" hidden>
											<input type="text" name="nome" value="<?= $row_prenotazioni['NomeTipico'] ?>" hidden>
											<?php
										}
										?>
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
									<form action="accetta_prenotazioni_cibi.php" method="post">
										<td>Accetta Prenotazione&nbsp;<input type="submit" value="Accetta"></td>
										<input type="text" name="idprencibi" value="<?= $row_prenotazioni['idPrenCibi'] ?>" hidden>
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
				<form action="cancella_tutte_prenotazioni_cibi.php">
					Cancella tutte le prenotazioni&nbsp;<input type="submit" value="Cancella">
				</form>
				<?php
			}
		}
	}
	if ($utente == "Cliente") {
		?>
		<form action="visual_old_prenotazioni_cibi.php">
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
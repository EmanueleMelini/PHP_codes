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

$queryeliminato = "UPDATE PrenSoggiorni SET Eliminato = 1 WHERE DataInizio < '$dataoggi'";
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
$idprensoggiorni = $_POST['idprensoggiorni'];
$numero = $_POST['numero'];
$prezzo = $_POST['prezzo'];
?>
<form action="cancella_prenotazione_soggiorno.php" method="post">
	Vuoi cancellare davvero la prenotazione della camera numero: <?= $numero ?>?&nbsp;<input type="submit" value="Cancella">
	<input type="text" name="idprensoggiorni" value="<?= $idprensoggiorni ?>" hidden>
	<input type="text" name="prezzo" value="<?= $prezzo ?>" hidden>
	<input type="text" name="numero" value="<?= $numero ?>" hidden>
</form>
<form action="visual_prenotazioni_soggiorni.php">
	<br>Torna alla visualizzazione delle prenotazioni&nbsp;<input type="submit" value="Vai">
	<?php
	} else {
		if ($utente === "Cliente") {
			$queryprenotazioni = "SELECT idPrenSoggiorni, idCamera, Numero, Prezzo, idCliente, DataInizio, DataFine, Nome AS NomeT, MaxPersone, Eliminato, Accettato
FROM prensoggiorni INNER JOIN camere ON prensoggiorni.idCamera = camere.idCamere INNER JOIN TipiCamere ON TipiCamere.idTipiCamere = Camere.idTipoCamera
WHERE Eliminato = 0 AND idCliente = $_SESSION[idCliente]";
		} else {
			$queryprenotazioni = "SELECT idPrenSoggiorni, idCamera, Numero, Prezzo, idCliente, DataInizio, DataFine, Clienti.Nome AS NomeC, Clienti.Cognome AS CognomeC, TipiCamere.Nome AS NomeT, MaxPersone, Eliminato, Accettato
FROM prensoggiorni INNER JOIN camere ON prensoggiorni.idCamera = camere.idCamere INNER JOIN Clienti ON CLienti.idClienti = PrenSoggiorni.idCLiente INNER JOIN TipiCamere ON TipiCamere.idTipiCamere = Camere.idTipoCamera
WHERE Eliminato = 0";
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
							<td>Numero camera: <?= $row_prenotazioni['Numero'] ?></td>
							<td>Data inizio prenotazione: <?= $row_prenotazioni['DataInizio'] ?></td>
							<td>Data fine prenotazione: <?= $row_prenotazioni['DataFine'] ?></td>
							<td>Prezzo: <?= $row_prenotazioni['Prezzo'] ?></td>
							<td>Nome: <?= $row_prenotazioni['NomeT'] ?></td>
							<td>MaxPersone: <?= $row_prenotazioni['MaxPersone'] ?></td>
							<?php
							if ($utente === "Dipendente") {
								?>
								<td>Cliente: <?= $row_prenotazioni['NomeC'] . " " . $row_prenotazioni['CognomeC'] ?></td>
								<?php
							}
							if ($utente == "Cliente" || $utente == "Amministratore") {
								if ($row_prenotazioni['Accettato'] == 0) {
									?>
									<form action="" method="post">
										<td>Cancella Prenotazione&nbsp;<input type="submit" value="Cancella"></td>
										<input type="hidden" name="prezzo" value="<?= $row_prenotazioni['Prezzo'] ?>">
										<input type="hidden" name="numero" value="<?= $row_prenotazioni['Numero'] ?>">
										<input type="hidden" name="idprensoggiorni" value="<?= $row_prenotazioni['idPrenSoggiorni'] ?>">
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
									<form action="accetta_prenotazioni_soggiorni.php" method="post">
										<td>
											Accetta Prenotazione&nbsp;<input type="submit" value="Accetta">
											<input type="text" name="idprensoggiorni" value="<?= $row_prenotazioni['idPrenSoggiorni'] ?>" hidden>
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
					echo("<br>Per un totale di $totprezzo euro");
				}
				?>
				<br><br>
				<form action="cancella_tutte_prenotazioni_soggiorni.php">
					Cancella tutte le prenotazioni&nbsp;<input type="submit" value="Cancella">
				</form>
				<?php
			}
		}
	}
	if ($utente == "Cliente") {
		?>
		<form action="visual_old_prenotazioni_soggiorni.php">
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

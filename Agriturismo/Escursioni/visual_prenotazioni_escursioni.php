<html>
<head>
	<title>Visualizza Prenotazioni</title>
</head>
<body>
<?php
//TODO: mettere accettazione
// mettere vecchie prenotazioni
if (!array_key_exists("HTTP_REFERER", $_SERVER)) {
	header("Location: http://localhost/Login/Agriturismo/hub.html");
} else {
	require '../agriturismo_connect.php';
	session_start();

	$dataoggi = date("Y-m-d");
	$oraoggi = date("H:i");

    $queryeliminato = "UPDATE prenescursioni SET Eliminato = 1 WHERE DataE < '$dataoggi'";
    $queryeliminato_result = $conn->query($queryeliminato);
    if(!$queryeliminato_result) {
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
		$idprenescursioni = $_POST['idprenescursioni'];
		$nome = $_POST['nome'];

		echo("Vuoi cancellare davvero la prenotazione di: $nome?");
		echo("
<form action='cancella_prenotazione_escursione.php' method='post'>
    <input type='submit' value='Elimina'>
    <input type='hidden' name='idprenescursioni' value='$idprenescursioni'>
</form>");
	} else {
		if ($utente === "Cliente") {
			$queryprenotazioni = "SELECT idPrenEscursioni, idEscursione, idCliente, DataE, idGuida, Escursioni.Nome as Nomees, Meta, Dipendenti.Nome, Cognome 
FROM PrenEscursioni, Escursioni, Dipendenti
WHERE Escursioni.idEscursioni = PrenEscursioni.idEscursione AND Dipendenti.idDipendenti = PrenEscursioni.idGuida AND DataE >= '$dataoggi' AND Eliminato = 0 AND idCliente = $_SESSION[idCliente]";
		} else {
			$queryprenotazioni = "SELECT idPrenEscursioni, idEscursione, idCliente, DataE, idGuida, Escursioni.Nome as Nomees, Meta, Dipendenti.Nome, Dipendenti.Cognome, Clienti.Nome as NomeC, Clienti.Cognome as CognomeC
FROM PrenEscursioni, Escursioni, Dipendenti, Clienti
WHERE Escursioni.idEscursioni = PrenEscursioni.idEscursione AND Dipendenti.idDipendenti = PrenEscursioni.idGuida AND PrenEscursioni.idCLiente = Clienti.idCLienti AND DataE >= '$dataoggi' AND Eliminato = 0";
		}
		$queryprenotazioni_result = $conn->query($queryprenotazioni);
		if (!$queryprenotazioni_result) {
			echo("Errore nella query");
		} else {
			if ($utente === "Cliente") {
				echo("Prenotazioni del cliente $_SESSION[Nome] $_SESSION[Cognome]<br><br>");
			} else if($utente == "Dipendente"){
                echo("Dipendente $_SESSION[Nome] $_SESSION[Cognome]<br><br>");
            } else {
                echo("Amministratore $_SESSION[Nome] $_SESSION[Cognome]<br><br>");
            }
			if ($queryprenotazioni_result->num_rows === 0) {
				echo("Nessuna prenotazione attiva");
			} else {
				echo("<table border='1'>");
				$row_prenotazioni = $queryprenotazioni_result->fetch_array();
				while ($row_prenotazioni != null) {
					echo("<tr>");
					echo("<td>Nome Escursione: $row_prenotazioni[Nomees]</td>");
					echo("<td>Meta: $row_prenotazioni[Meta]</td>");
					echo("<td>Guida: $row_prenotazioni[Nome] $row_prenotazioni[Cognome]</td>");
					echo("<td>Data Prenotazione: $row_prenotazioni[DataE]</td>");
					echo("<td>Prezzo: $row_prenotazioni[Prezzo]</td>");
					if ($utente === "Dipendente") {
						echo("<td>Cliente: $row_prenotazioni[NomeC] $row_prenotazioni[CognomeC]</td>");
					}
					echo("<form action='' method='post'>");
					echo("<td>Cancella Prenotazione&nbsp;<input type='submit' value='Cancella'></td>");
					echo("<input type='hidden' name='idprenescursioni' value='$row_prenotazioni[idPrenEscursioni]'>");
					echo("<input type='hidden' name='nome' value='$row_prenotazioni[Nomees]'></form>");
					echo("</tr>");
					$row_prenotazioni = $queryprenotazioni_result->fetch_array();
				}
				echo("</table>");
				echo("<br><br><form action='cancella_tutte_prenotazioni_escursioni.php'>Cancella tutte le prenotazioni&nbsp;<input type='submit' value='Cancella'></form>");
			}
		}
	}
	if ($utente === "Cliente") {
		echo("<form action='../portale.php'>");
	} else {
		echo("<form action='../portaledip.php'>");

	}

	?>
	<form action="<?= $urlportale ?>">
		<br>Torna al portale&nbsp;<input type="submit" value="Vai">
	</form>
	<?php
}
?>
</body>
</html>

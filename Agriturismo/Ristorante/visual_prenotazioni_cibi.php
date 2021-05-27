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

    $queryeliminato = "UPDATE PrenCibi SET Eliminato = 1 WHERE DataP < '$dataoggi'";
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
		$idprencibi = $_POST['idprencibi'];
		$nome = $_POST['nome'];
		$prezzo = $_POST['prezzo'];

		echo("Vuoi cancellare davvero la prenotazione di: $nome?");
		echo("
<form action='elimina_prenotazione_cibo.php' method='post'>
    <input type='submit' value='Elimina'>
    <input type='hidden' name='idprencibi' value='$idprencibi'>
    <input type='hidden' name='prezzo' value='$prezzo'>
</form>");
	} else {
		if ($utente == "Cliente") {
			$queryprenotazioni = "select idPrenCibi, idCLiente, DataP, OraP, Tavolo, idPiattoTipico, piattitipici.Nome as NomeTipico, piattitipici.Prezzo as PrezzoTipico, idPizza, pizze.Nome as NomePizza, pizze.Prezzo as PrezzoPizza
from (prencibi left outer join piattitipici on prencibi.idPiattoTipico = piattitipici.idPiattiTipici)
left outer join pizze on pizze.idPizze = prencibi.idPizza 
where Datap >= '$dataoggi' and OraP >= '$oraoggi' and Eliminato = 0 and idCliente = $_SESSION[idCliente]";
		} else {
			$queryprenotazioni = "select idPrenCibi, idCLiente, DataP, OraP, Tavolo, idPiattoTipico, piattitipici.Nome as NomeTipico, piattitipici.Prezzo as PrezzoTipico, idPizza, pizze.Nome as NomePizza, pizze.Prezzo as PrezzoPizza, Clienti.Nome as NomeC, Clienti.Cognome as CognomeC
from (prencibi left outer join piattitipici on prencibi.idPiattoTipico = piattitipici.idPiattiTipici)
left outer join pizze on pizze.idPizze = prencibi.idPizza inner join Clienti on PrenCibi.idCLiente = Clienti.idCLienti
where Datap >= '$dataoggi' and OraP >= '$oraoggi' and Eliminato = 0";
		}
		$queryprenotazioni_result = $conn->query($queryprenotazioni);
		if (!$queryprenotazioni_result) {
			echo("Errore nella query");
		} else {
			$totprezzo = 0;
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
					if ($row_prenotazioni['idPiattoTipico'] == null) {
						$totprezzo = $totprezzo + $row_prenotazioni['PrezzoPizza'];
						echo("<td>Nome Pizza: $row_prenotazioni[NomePizza]</td>");
						echo("<td>Prezzo: $row_prenotazioni[PrezzoPizza]</td>");
					} else {
						$totprezzo = $totprezzo + $row_prenotazioni['PrezzoTipico'];
						echo("<td>Nome Piatto Tipico: $row_prenotazioni[NomeTipico]</td>");
						echo("<td>Prezzo: $row_prenotazioni[PrezzoTipico]</td>");
					}
					echo("<td>Data Prenotazione: $row_prenotazioni[DataPren]</td>");
					echo("<td>Ora Prenotazione: $row_prenotazioni[OraPren]</td>");
					echo("<td>Numero tavolo: $row_prenotazioni[Tavolo]</td>");
					if ($utente === "Dipendente") {
						echo("<td>Cliente: $row_prenotazioni[NomeC] $row_prenotazioni[CognomeC]</td>");
					}
					echo("<form action='' method='post'><td>Cancella Prenotazione&nbsp;<input type='submit' value='Cancella'></td><input type='hidden' name='idprencibi' value='$row_prenotazioni[idPrenCibi]'>");
					if ($row_prenotazioni['idPiattoTipico'] == null) {
						echo("<input type='hidden' name='prezzo' value='$row_prenotazioni[PrezzoPizza]'>");
						echo("<input type='hidden' name='nome' value='$row_prenotazioni[NomePizza]'></form>");
					} else {
						echo("<input type='hidden' name='prezzo' value='$row_prenotazioni[PrezzoTipico]'>");
						echo("<input type='hidden' name='nome' value='$row_prenotazioni[NomeTipico]'></form>");
					}
					echo("</tr>");
					$row_prenotazioni = $queryprenotazioni_result->fetch_array();
				}
				echo("</table>");
				if ($utente === "Cliente") {
					echo("<br>Per un totale di $totprezzo euro");
				}
				$_SESSION['totprezzo'] = $totprezzo;
				echo("<br><br><form action='cancella_tutte_prenotazioni_cibi.php'>Cancella tutte le prenotazioni&nbsp;<input type='submit' value='Cancella'></form>");
			}
		}
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

<html>
<head>
    <title>Visualizza Prenotazioni</title>
</head>
<body>
<?php
if (!array_key_exists("HTTP_REFERER", $_SERVER)) {
    header("Location: http://localhost/Login/Agriturismo/hub.html");
} else {
    require 'agriturismo_connect.php';
    session_start();

    $dataoggi = date("Y-m-d");
    $oraoggi = date("H:i");

    if ($_SESSION['Tipo'] === "Cliente") {
        $utente = "Cliente";
    } else {
        $utente = "Dipendente";
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $idprensoggiorni = $_POST['idprensoggiorni'];
        $numero = $_POST['numero'];
        $prezzo = $_POST['prezzo'];

        echo("
<form action='cancella_prenotazione_soggiorno.php' method='post'>
    Vuoi cancellare davvero la prenotazione della camera numero: $numero?&nbsp;<input type='submit' value='Elimina'>
    <input type='text' name='idprensoggiorni' value='$idprensoggiorni' hidden>
    <input type='text' name='prezzo' value='$prezzo' hidden>
    <input type='text' name='numero' value='$numero' hidden>
</form>");
        echo("<form action='visual_prenotazioni_soggiorni.php'>
    <br>Torna alla visualizzazione delle prenotazioni&nbsp;<input type='submit' value='Vai'>
");
    } else {
        if ($utente === "Cliente") {
            $queryprenotazioni = "SELECT idPrenSoggiorni, idCamera, Numero, Prezzo, MaxPersone, idCliente, DataInizio, DataFine 
FROM prensoggiorni INNER JOIN camere ON prensoggiorni.idCamera = camere.idCamere 
WHERE DataInizio >= '$dataoggi' and Eliminato = 0 and idCliente = $_SESSION[idCliente]";
        } else {
            $queryprenotazioni = "SELECT idPrenSoggiorni, idCamera, Numero, Prezzo, MaxPersone, idCliente, DataInizio, DataFine, Clienti.Nome as NomeC, Clienti.Cognome as CognomeC
FROM prensoggiorni INNER JOIN camere ON prensoggiorni.idCamera = camere.idCamere INNER JOIN Clienti on CLienti.idClienti = PrenSoggiorni.idCLiente
WHERE Eliminato = 0";
            //DataInizio >= '$dataoggi' and
        }
        $queryprenotazioni_result = $conn->query($queryprenotazioni);
        if (!$queryprenotazioni_result) {
            echo("Errore nella query");
        } else {
            $totprezzo = 0;
            if($utente === "Cliente") {
                echo("Prenotazioni del cliente $_SESSION[Nome] $_SESSION[Cognome]<br><br>");
            } else {
                echo("Dipendente $_SESSION[Nome] $_SESSION[Cognome]<br><br>");
            }
            if ($queryprenotazioni_result->num_rows === 0) {
                echo("Nessuna prenotazione attiva");
            } else {
                echo("<table border='1'>");
                $row_prenotazioni = $queryprenotazioni_result->fetch_array();
                while ($row_prenotazioni != null) {
                    $totprezzo = $totprezzo + $row_prenotazioni['Prezzo'];
                    echo("<tr><td>Numero camera: $row_prenotazioni[Numero]</td>");
                    echo("<td>Data inizio prenotazione: $row_prenotazioni[DataInizio]</td>");
                    echo("<td>Data fine prenotazione: $row_prenotazioni[DataFine]</td>");
                    echo("<td>Prezzo: $row_prenotazioni[Prezzo]</td>");
                    if ($utente === "Dipendente") {
                        echo("<td>Cliente: $row_prenotazioni[NomeC] $row_prenotazioni[CognomeC]</td>");
                    }
                    echo("<form action='' method='post'>");
                    echo("<td>Cancella Prenotazione&nbsp;<input type='submit' value='Cancella'></td>");
                    echo("<input type='hidden' name='prezzo' value='$row_prenotazioni[Prezzo]'>");
                    echo("<input type='hidden' name='numero' value='$row_prenotazioni[Numero]'>");
                    echo("<input type='hidden' name='idprensoggiorni' value='$row_prenotazioni[idPrenSoggiorni]'></form>");
                    echo("</tr>");
                    $row_prenotazioni = $queryprenotazioni_result->fetch_array();
                }
                echo("</table>");
                if($utente === "Cliente") {
                    echo("<br>Per un totale di $totprezzo euro");
                }
                $_SESSION['totprezzo'] = $totprezzo;
                echo("<br><br><form action='cancella_tutte_prenotazioni_soggiorni.php'>Cancella tutte le prenotazioni&nbsp;<input type='submit' value='Cancella'></form>");
            }
        }
    }
    if ($utente === "Cliente") {
        echo("<form action='portale.php'>");
    } else {
        echo("<form action='portaledip.php'>");
    }
}
?>
<br>Torna al portale&nbsp;<input type="submit" value="Vai">
</form>
</body>
</html>

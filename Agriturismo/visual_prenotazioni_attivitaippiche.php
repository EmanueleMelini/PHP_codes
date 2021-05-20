<?php
if (!array_key_exists("HTTP_REFERER", $_SERVER)) {
    header("Location: http://localhost/Login/Agriturismo/hub.html");
} else {
    require 'agriturismo_connect.php';
    session_start();
    $dataoggi = date("Y-m-d");
    $oraoggi = date("H:i");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $idprenattivitaippiche = $_POST['idprenattivitaippiche'];
        $nome = $_POST['nome'];

        echo("Vuoi cancellare davvero la prenotazione di: $nome?");
        echo("
<form action='cancella_prenotazione_attivitaippica.php' method='post'>
    <input type='submit' value='Elimina'>
    <input type='hidden' name='idprenattivitaippiche' value='$idprenattivitaippiche'>
</form>");
    } else {
        $queryprenotazioni = "SELECT idPrenAttivita, idAttivita, idCliente, DataA, OraInizio, OraFine, idAddetto, AttivitaIppiche.Nome as Nomeatt, NomeCavallo, Dipendenti.Nome, Cognome 
FROM PrenAttivita, AttivitaIppiche, Dipendenti
WHERE AttivitaIppiche.idAttivitaIppiche = PrenAttivita.idPrenAttivita AND Dipendenti.idDipendenti = PrenAttivita.idAddetto AND DataA >= '$dataoggi' AND Eliminato = 0 AND idCliente = $_SESSION[idCliente]";
        $queryprenotazioni_result = $conn->query($queryprenotazioni);
        if (!$queryprenotazioni_result) {
            echo("Errore nella query");
        } else {
            echo("Prenotazioni del cliente $_SESSION[Nome] $_SESSION[Cognome]<br><br>");
            if ($queryprenotazioni_result->num_rows === 0) {
                echo("Nessuna prenotazione attiva");
            } else {
                echo("<table border='1'>");
                $row_prenotazioni = $queryprenotazioni_result->fetch_array();
                while ($row_prenotazioni != null) {
                    echo("<tr>");
                    echo("<td>Nome Attivita: $row_prenotazioni[Nomeatt]</td>");
                    echo("<td>Nome Cavallo: $row_prenotazioni[NomeCavallo]</td>");
                    echo("<td>Addetto: $row_prenotazioni[Nome] $row_prenotazioni[Cognome]</td>");
                    echo("<td>Data Prenotazione: $row_prenotazioni[DataA]</td>");
                    echo("<form action='' method='post'>");
                    echo("<td>Cancella Prenotazione&nbsp;<input type='submit' value='Cancella'></td>");
                    echo("<input type='hidden' name='idprenattivitaippiche' value='$row_prenotazioni[idPrenAttivita]'>");
                    echo("<input type='hidden' name='nome' value='$row_prenotazioni[Nomeatt]'></form>");
                    echo("</tr>");
                    $row_prenotazioni = $queryprenotazioni_result->fetch_array();
                }
                echo("</table>");
                echo("<br><br><form action='cancella_tutte_prenotazioni_attivitaippiche.php'>Cancella tutte le prenotazioni&nbsp;<input type='submit' value='Cancella'></form>");
            }
        }
    }
}
?>
<html>
<head>
    <title>Visualizza Prenotazioni</title>
</head>
<body>
<form action="portale.php">
    <br>Torna al portale&nbsp;<input type="submit" value="Vai">
</form>
</body>
</html>

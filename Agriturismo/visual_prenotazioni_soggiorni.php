<?php
if (!array_key_exists("HTTP_REFERER", $_SERVER)) {
    header("Location: http://localhost/Login/Agriturismo/hub.html");
} else {
    require 'agriturismo_connect.php';
    session_start();

    $dataoggi = date("Y-m-d");
    $oraoggi = date("H:i");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $idprensoggiorni = $_POST['idprensoggiorni'];
        $numero = $_POST['numero'];
        $prezzo = $_POST['prezzo'];

        echo("
<form action='cancella_prenotazione_soggiorno.php' method='post'>
    Vuoi cancellare davvero la prenotazione della camera numero: $numero?&nbsp;<input type='submit' value='Elimina'>
    <input type='hidden' name='idprensoggiorni' value='$idprensoggiorni'>
    <input type='hidden' name='prezzo' value='$prezzo'>
</form>");
        echo("<form action='visual_prenotazioni_soggiorni.php'>
    <br>Torna alla visualizzazione delle prenotazioni&nbsp;<input type='submit' value='Vai'>
");
    } else {
        $queryprenotazioni = "SELECT idPrenSoggiorni, idCamera, Numero, Prezzo, MaxPersone, idCliente, DataInizio, DataFine 
FROM prensoggiorni INNER JOIN camere ON prensoggiorni.idCamera = camere.idCamere 
WHERE DataInizio >= '$dataoggi' and Eliminato = 0 and idCliente = $_SESSION[idCliente]";
        $queryprenotazioni_result = $conn->query($queryprenotazioni);
        if (!$queryprenotazioni_result) {
            echo("Errore nella query");
        } else {
            $totprezzo = 0;
            echo("Prenotazioni del cliente $_SESSION[Nome] $_SESSION[Cognome]<br><br>");
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
                    echo("<form action='' method='post'>
<input type='hidden' name='prezzo' value='$row_prenotazioni[Prezzo]'>
<input type='hidden' name='numero' value='$row_prenotazioni[Numero]'>
<input type='hidden' name='idprensoggiorni' value='$row_prenotazioni[idPrenSoggiorni]'>
<td>Cancella Prenotazione&nbsp;<input type='submit' value='Cancella'></form></td></tr><br><br>");
                    $row_prenotazioni = $queryprenotazioni_result->fetch_array();
                }
                echo("</table><br>");
                echo("Per un totale di $totprezzo euro");
                $_SESSION['totprezzo'] = $totprezzo;
                echo("<br><br><form action='cancella_tutte_prenotazioni_soggiorni.php'>Cancella tutte le prenotazioni&nbsp;<input type='submit' value='Cancella'></form>");
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

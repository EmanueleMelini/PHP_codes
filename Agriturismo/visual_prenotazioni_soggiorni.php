<?php
require 'agriturismo_connect.php';
session_start();

$dataoggi = date("Y-m-d");
$oraoggi = date("H:i");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idprensoggiorni = $_POST['idprensoggiorni'];
    $numero= $_POST['numero'];
    $prezzo = $_POST['prezzo'];

    echo("Vuoi cancellare davvero la prenotazione della camera numero: $numero?");
    echo("
<form action='cancella_prenotazione_soggiorno.php' method='post'>
    <input type='submit' value='Elimina'>
    <input type='hidden' name='idprensoggiorni' value='$idprensoggiorni'>
    <input type='hidden' name='prezzo' value='$prezzo'>
</form>");
} else {
    $queryprenotazioni = "SELECT idPrenSoggiorni, idCamera, Numero, Prezzo, MaxPersone, idCliente, DataInizio, DataFine 
FROM prensoggiorni INNER JOIN camere ON prensoggiorni.idCamera = camere.idCamere 
WHERE DataInizio >= '$dataoggi' and Eliminato = 0 and idCliente = $_SESSION[idCliente]";
    $queryprenotazioni_result = $conn->query($queryprenotazioni);
    if (!$queryprenotazioni_result) {
        echo("Errore nella query");
    } else {
        $totprezzo = 0;
        echo("Prenotazioni del cliente $_SESSION[Nome] $_SESSION[Cognome]<br>");
        $row_prenotazioni = $queryprenotazioni_result->fetch_array();
        while ($row_prenotazioni != null) {
            $totprezzo = $totprezzo + $row_prenotazioni['Prezzo'];
            echo("Numero camera: $row_prenotazioni[Numero]");
            echo(".&nbsp;&nbsp;Data inizio prenotazione: $row_prenotazioni[DataInizio].&nbsp;&nbsp;Data fine prenotazione: $row_prenotazioni[DataFine].&nbsp;&nbsp;Prezzo: $row_prenotazioni[Prezzo].<br>");
            echo("<form action='' method='post'>
<input type='hidden' name='prezzo' value='$row_prenotazioni[Prezzo]'>
<input type='hidden' name='numero' value='$row_prenotazioni[Numero]'>
<input type='hidden' name='idprensoggiorni' value='$row_prenotazioni[idPrenSoggiorni]'>
Cancella Prenotazione&nbsp;<input type='submit' value='Cancella'></form><br><br>");
            $row_prenotazioni = $queryprenotazioni_result->fetch_array();
        }
        echo("Per un totale di $totprezzo euro");
        $_SESSION['totprezzo'] = $totprezzo;
        echo("<br><form action='cancella_tutte_prenotazioni_soggiorni.php'>Cancella Tutto&nbsp;<input type='submit' value='Cancella'></form>");
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

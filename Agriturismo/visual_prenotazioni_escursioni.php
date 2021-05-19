<?php
require 'agriturismo_connect.php';
session_start();

$dataoggi = date("Y-m-d");
$oraoggi = date("H:i");

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
    $queryprenotazioni = "SELECT idPrenEscursioni, idEscursione, idCliente, DataE, idGuida, Escursioni.Nome as Nomees, Meta, Guide.Nome, Cognome 
FROM PrenEscursioni, Escursioni, Guide
WHERE Escursioni.idEscursioni = PrenEscursioni.idEscursione AND Guide.idGuide = PrenEscursioni.idGuida AND DataE >= '$dataoggi' AND Eliminato = 0 AND idCliente = $_SESSION[idCliente]";
    $queryprenotazioni_result = $conn->query($queryprenotazioni);
    if (!$queryprenotazioni_result) {
        echo("Errore nella query");
    } else {
        echo("Prenotazioni del cliente $_SESSION[Nome] $_SESSION[Cognome]<br><br>");
        echo("<table border='1'>");
        $row_prenotazioni = $queryprenotazioni_result->fetch_array();
        while ($row_prenotazioni != null) {
            echo("<tr>");
            echo("<td>Nome Escursione: $row_prenotazioni[Nomees]</td>");
            echo("<td>Meta: $row_prenotazioni[Meta]</td>");
            echo("<td>Guida: $row_prenotazioni[Nome] $row_prenotazioni[Cognome]</td>");
            echo("<td>Data Prenotazione: $row_prenotazioni[DataE]</td>");
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

<?php
require 'agriturismo_connect.php';
session_start();
$listaid = $_POST['listaid'];
$listaidarray = explode(",", $listaid);
$datapren = $_POST['datapren'];
$orainizio = $_POST['orainizio'];
$orafine = $_POST['orafine'];
$dataoggi = date("Y-m-d");
$oraoggi = date("H:i");
$listaaddettiippica = $_POST['listaaddettiippica'];
$listaaddettiippicaarray = explode(",", $listaaddettiippica);
$f = true;
for ($i = 0; $i < count($listaidarray); $i++) {
    $queryprenotazione = "INSERT INTO PrenAttivita(idAttivita, idCliente, DataP, OraP, DataA, OraInizio, OraFine, idAddetto)
VALUES('$listaidarray[$i]', '$_SESSION[idCliente]', '$dataoggi', '$oraoggi', '$datapren', '$orainizio', '$orafine', '$listaaddettiippicaarray[$i]')";

    $queryprenotazione_result = $conn->query($queryprenotazione);
    if (!$queryprenotazione_result) {
        echo("Errore nella query $i");
        $f = false;
    }
}
if ($f)
    echo("Ordine prenotato correttamente");
?>
<form action="portale.php">
    Torna all'hub&nbsp;<input type="submit" value="Hub">
</form>
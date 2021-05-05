<?php
require 'agriturismo_connect.php';
session_start();

$listaid = $_POST['listaid'];
$listaidarray = explode(",", $listaid);
$datainiziopren = $_POST['datainiziopren'];
$datafinepren = $_POST['datafinepren'];
$dataoggi = date("Y-m-d");
$oraoggi = date("H:i");
for ($i = 0; $i < count($listaidarray); $i++) {
        $queryprenotazione = "INSERT INTO PrenSoggiorni(idCamera, idCliente, DataInizio, DataFine, DataIns, OraIns)
VALUES('$listaidarray[$i]', '$_SESSION[idCliente]', '$datainiziopren', '$datafinepren', '$dataoggi', '$oraoggi')";
    $queryprenotazione_result = $conn->query($queryprenotazione);
    if (!$queryprenotazione_result) {
        echo("Errore nella query $i");
    }
}

echo("Ordine prenotato correttamente");
?>
<form action="portale.php">
    Torna all'hub&nbsp;<input type="submit" value="Hub">
</form>

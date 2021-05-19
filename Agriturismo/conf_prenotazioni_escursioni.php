<?php
require 'agriturismo_connect.php';
session_start();
$listaid = $_POST['listaid'];
$listaidarray = explode(",", $listaid);
$datapren = $_POST['datapren'];
$dataoggi = date("Y-m-d");
$oraoggi = date("H:i");
$listaguide = $_POST['listaguide'];
$listaguidearray = explode(",", $listaguide);
$f = true;
for ($i = 0; $i < count($listaidarray); $i++) {
    $queryprenotazione = "INSERT INTO PrenEscursioni(idEscursione, idCLiente, DataP, OraP, DataE, idGuida)
VALUES('$listaidarray[$i]', '$_SESSION[idCliente]', '$dataoggi', '$oraoggi', '$datapren', '$listaguidearray[$i]')";

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

<?php
if (!array_key_exists("HTTP_REFERER", $_SERVER)) {
    header("Location: http://localhost/Login/Agriturismo/hub.html");
} else {
    require 'agriturismo_connect.php';
    session_start();
    $listaid = $_POST['listaid'];
    $listaidarray = explode(",", $listaid);
    $orapren = $_POST['orapren'];
    $dataoggi = date("Y-m-d");
    $oraoggi = date("H:i");
    $tavolo = $_POST['tavolo'];
    $tipo = $_POST['tipo'];
    for ($i = 0; $i < count($listaidarray); $i++) {
        if ($tipo == "pizze") {
            $queryprenotazione = "INSERT INTO PrenCibi(idPizza, idCLiente, DataPren, Ora, Tavolo, OraPren)
VALUES('$listaidarray[$i]', '$_SESSION[idCliente]', '$dataoggi', '$oraoggi', '$tavolo', '$orapren')";
        } else {
            $queryprenotazione = "INSERT INTO PrenCibi(idPiattoTipico, idCLiente, DataPren, Ora, Tavolo, OraPren)
VALUES('$listaidarray[$i]', '$_SESSION[idCliente]', '$dataoggi', '$oraoggi', '$tavolo', '$orapren')";
        }
        $queryprenotazione_result = $conn->query($queryprenotazione);
        if (!$queryprenotazione_result) {
            echo("Errore nella query $i");
        }
    }

    echo("Ordine prenotato correttamente");
}
?>
<form action="portale.php">
    Torna all'hub&nbsp;<input type="submit" value="Hub">
</form>

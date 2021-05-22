<?php
if (!array_key_exists("HTTP_REFERER", $_SERVER)) {
    header("Location: http://localhost/Login/Agriturismo/hub.html");
} else {
    require 'agriturismo_connect.php';
    session_start();

    $listaid = $_POST['listaid'];
    $listaidarray = explode(",", $listaid);
    $datainiziopren = $_POST['datainiziopren'];
    $datafinepren = $_POST['datafinepren'];
    $dataoggi = date("Y-m-d");
    $oraoggi = date("H:i");
    for ($i = 0; $i < count($listaidarray); $i++) {
        $queryprenotazione = "INSERT INTO PrenSoggiorni(idCamera, idCliente, DataP, OraP, DataInizio, DataFine)
VALUES('$listaidarray[$i]', '$_SESSION[idCliente]', '$dataoggi', '$oraoggi', '$datainiziopren', '$datafinepren')";
        $queryprenotazione_result = $conn->query($queryprenotazione);
        if (!$queryprenotazione_result) {
            echo("Errore nella query $i");
        } else {
            $querycamera = "UPDATE Camere SET Ordinata = 1 where idCamere = $listaidarray[$i]";
            $querycamera_result = $conn->query($querycamera);
            if(!$querycamera_result) {
                echo("Errore nella query $i");
            }
        }
    }

    echo("Ordine prenotato correttamente");
}
?>
<form action="portale.php">
    Torna all'hub&nbsp;<input type="submit" value="Hub">
</form>

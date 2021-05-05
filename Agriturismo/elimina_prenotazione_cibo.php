<?php
require 'agriturismo_connect.php';
session_start();
$idprencibi = $_POST['idprencibi'];
$prezzo = $_POST['prezzo'];
#$queryeliminaprenotazione = "DELETE FROM PrenCibi WHERE idPrenCibi = '$idprencibi'";
$queryeliminaprenotazione = "UPDATE PrenCibi SET Eliminato = 1 WHERE idPrenCibi = '$idprencibi'";
$queryeliminaprenotazione_result = $conn->query($queryeliminaprenotazione);
if (!$queryeliminaprenotazione_result) {
    echo("Errore nella query");
} else {
    $_SESSION['totprezzo'] = $_SESSION['totprezzo'] - $prezzo;
    echo("Prenotazione cancellata correttamente");
}
?>
<html>
<head>
    <title>Cancellazione Prenotazione</title>
</head>
<body>
<form action="visual_prenotazioni_cibi.php">
    <br>Torna alla visualizzazione delle prenotazioni&nbsp;<input type="submit" value="Vai">
</form>
<form action="portale.php">
    Torna al portale&nbsp;<input type="submit" value="Vai">
</form>
</body>
</html>

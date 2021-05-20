<?php
if (!array_key_exists("HTTP_REFERER", $_SERVER)) {
    header("Location: http://localhost/Login/Agriturismo/hub.html");
} else {
    require 'agriturismo_connect.php';
    session_start();
    $idprenescursioni = $_POST['idprenescursioni'];
    $queryeliminaprenotazione = "UPDATE PrenEscursioni SET Eliminato = 1 WHERE idPrenEscursioni = '$idprenescursioni'";
    $queryeliminaprenotazione_result = $conn->query($queryeliminaprenotazione);
    if (!$queryeliminaprenotazione_result) {
        echo("Errore nella query");
    } else {
        echo("Prenotazione cancellata correttamente");
    }
}
?>
<html>
<head>
    <title>Cancellazione Prenotazione</title>
</head>
<body>
<form action="visual_prenotazioni_escursioni.php">
    <br>Torna alla visualizzazione delle prenotazioni&nbsp;<input type="submit" value="Vai">
</form>
<form action="portale.php">
    Torna al portale&nbsp;<input type="submit" value="Vai">
</form>
</body>
</html>

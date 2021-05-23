<html>
<head>
    <title>Cancellazione tutte Prenotazioni</title>
</head>
<?php
if (!array_key_exists("HTTP_REFERER", $_SERVER)) {
    header("Location: http://localhost/Login/Agriturismo/hub.html");
} else {
require '../agriturismo_connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$queryeliminaprenotazione = "UPDATE PrenAttivita SET Eliminato = 1 WHERE idCliente = '$_SESSION[idCliente]'";
$queryeliminaprenotazione_result = $conn->query($queryeliminaprenotazione);
if (!$queryeliminaprenotazione_result) {
    echo("Errore nella query");
} else {
    echo("Prenotazione cancellata correttamente");
}
?>
<body>
<form action="visual_prenotazioni_attivitaippiche.php">
    <br>Torna alla visualizzazione delle prenotazioni&nbsp;<input type="submit" value="Vai">
</form>
<form action="../portale.php">
    Torna al portale&nbsp;<input type="submit" value="Vai">
</form>
</body>
</html>
<?php
} else {
    echo("Vuoi cancellare davvero tutte le prenotazioni?");
    echo("
<form action='' method='post'>
    <input type='submit' value='Elimina'>
</form>");
}
}
<html>
<head>
    <title>Cancellazione tutte Prenotazioni</title>
</head>
<?php
require 'agriturismo_connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$queryeliminaprenotazione = "UPDATE PrenCibi SET Eliminato = 1 WHERE idCliente = '$_SESSION[idCliente]'";
$queryeliminaprenotazione_result = $conn->query($queryeliminaprenotazione);
if (!$queryeliminaprenotazione_result) {
    echo("Errore nella query");
} else {
    $_SESSION['totprezzo'] = 0;
    echo("Prenotazione cancellata correttamente");
}
?>
<body>
<form action="visual_prenotazioni_cibi.php">
    <br>Torna alla visualizzazione delle prenotazioni&nbsp;<input type="submit" value="Vai">
</form>
<form action="portale.php">
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
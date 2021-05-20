<?php
require 'agriturismo_connect.php';
session_start();
$idprenattivitaippiche = $_POST['idprenattivitaippiche'];
$queryeliminaprenotazione = "UPDATE PrenAttivita SET Eliminato = 1 WHERE idPrenAttivita = '$idprenattivitaippiche'";
$queryeliminaprenotazione_result = $conn->query($queryeliminaprenotazione);
if (!$queryeliminaprenotazione_result) {
    echo("Errore nella query");
} else {
    echo("Prenotazione cancellata correttamente");
}
?>
<html>
<head>
    <title>Cancellazione Prenotazione</title>
</head>
<body>
<form action="visual_prenotazioni_attivitaippiche.php">
    <br>Torna alla visualizzazione delle prenotazioni&nbsp;<input type="submit" value="Vai">
</form>
<form action="portale.php">
    Torna al portale&nbsp;<input type="submit" value="Vai">
</form>
</body>
</html>

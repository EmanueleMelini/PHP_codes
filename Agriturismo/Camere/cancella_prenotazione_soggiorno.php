<html>
<head>
    <title>Cancella Prenotazione</title>
</head>
<body>
<?php
if (!array_key_exists("HTTP_REFERER", $_SERVER)) {
    header("Location: http://localhost/Login/Agriturismo/hub.html");
} else {
require '../agriturismo_connect.php';
session_start();

switch ($_SESSION['Tipo']) {
    case "Cliente":
        $urlportale = "../portale.php";
        break;
    case "Dipendente":
        $urlportale = "../portaledip.php";
        break;
    case "Amministratore":
        $urlportale = "../portaleadmin.php";
        break;
    default :
        $urlportale = "../hub.html";
        break;
}

$idprensoggiorni = $_POST['idprensoggiorni'];
$prezzo = $_POST['prezzo'];
$numero = $_POST['numero'];
$queryeliminaprenotazione = "UPDATE prensoggiorni SET Eliminato = 1 WHERE idPrenSoggiorni = '$idprensoggiorni'";
$queryeliminaprenotazione_result = $conn->query($queryeliminaprenotazione);
if (!$queryeliminaprenotazione_result) {
    echo("Errore nella query");
} else {
    $querycamera = "UPDATE Camere SET Ordinata = 0 where idCamere = '$numero'";
    $querycamera_result = $conn->query($querycamera);
    if (!$querycamera_result) {
        echo("Errore nella query");
    } else {
        $_SESSION['totprezzo'] = $_SESSION['totprezzo'] - $prezzo;
        echo("Prenotazione cancellata correttamente");
    }
}
?>
<form action="visual_prenotazioni_soggiorni.php">
    <br>Torna alla visualizzazione delle prenotazioni&nbsp;<input type="submit" value="Vai">
</form>
<form action="<?= $urlportale ?>">
    Torna al portale&nbsp;<input type="submit" value="Vai">
</form>
<?php
}
?>
</body>
</html>

<html>
<head>
    <title>Prenota Escursioni</title>
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
    <form action="<?= $urlportale ?>">
        Torna all'hub&nbsp;<input type="submit" value="Hub">
    </form>
    <?php
}
?>
</body>
</html>
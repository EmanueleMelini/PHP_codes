<html>
<head>
    <title>Conferma Prenotazioni Camere</title>
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

    $idcamera = $_POST['idcamera'];
    $datainiziopren = date_create($_POST['datainiziopren']);
    $datainizio = $_POST['datainiziopren'];
    $datafinepren = date_create($_POST['datafinepren']);
    $datafine = $_POST['datafinepren'];
    $dataoggi = date("Y-m-d");
    $oraoggi = date("H:i");

    $querycontrollodate = "SELECT DataInizio, DataFine FROM PrenSoggiorni INNER JOIN Camere ON PrenSoggiorni.idCamera = Camere.idCamere WHERE Camere.idCamere = '$idcamera'";
    $querycontrollodate_result = $conn->query($querycontrollodate);
    if (!$querycontrollodate_result) {
        echo("Errore nella query 1");
    } else {
        if ($querycontrollodate_result->num_rows == 0) {
            echo("Nessuna");
        } else {
            $flag = true;
            $row_controllodate = $querycontrollodate_result->fetch_array();
            echo("Data Inizio $datainizio data fine $datafine<br>");
            while ($row_controllodate != null && $flag) {
                $datainizioquery = date_create($row_controllodate['DataInizio']);
                $datafinequery = date_create($row_controllodate['DataFine']);
                if (($datainiziopren->getTimestamp() >= $datainizioquery->getTimestamp() && $datainiziopren->getTimestamp() <= $datafinequery->getTimestamp())
                    || ($datainiziopren->getTimestamp() <= $datainizioquery->getTimestamp() && $datafinepren->getTimestamp() >= $datafinequery->getTimestamp())
                    || ($datafinepren->getTimestamp() >= $datainizioquery->getTimestamp() && $datafinepren->getTimestamp() <= $datafinequery->getTimestamp())) {
                    $flag = false;
                }
                $row_controllodate = $querycontrollodate_result->fetch_array();
            }
            if ($flag) {

                $datainiziopren = $datainiziopren->format("Y-m-d");
                $datafinepren = $datafinepren->format("Y-m-d");
                $queryprenotazione = "INSERT INTO PrenSoggiorni(idCamera, idCliente, DataP, OraP, DataInizio, DataFine)
VALUES('$idcamera', '$_SESSION[idCliente]', '$dataoggi', '$oraoggi', '$datainiziopren)', '$datafinepren')";
                $queryprenotazione_result = $conn->query($queryprenotazione);
                if (!$queryprenotazione_result) {
                    echo("Errore nella query 2");
                } else {
                    echo("Camera prenotata correttamente");
                }
            } else {
                echo("Inserisci una data che non coincide con prenotazioni esistenti!");
            }
        }
    }
    ?>
    <form action="prenotazioni_camere.php" method="post">
        Torna alla prenotazione&nbsp;<input type="submit" value="Vai">
        <input type="text" value="<?= $idcamera ?>" name="idcamera" hidden>
    </form>
    <form action="<?= $urlportale ?>">
        Torna all'hub&nbsp;<input type="submit" value="Hub">
    </form>
    <?php
}
?>
</body>
</html>

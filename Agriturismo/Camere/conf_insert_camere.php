<html>
<head>
    <title>Inserisci Camera</title>
</head>
<body>
<?php
if (!array_key_exists("HTTP_REFERER", $_SERVER)) {
    session_destroy();
    header("Location: http://localhost/Login/Agriturismo/hub.html");
} else {
    session_start();
    require '../agriturismo_connect.php';

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

    $numero = $_POST['numero'];
    $prezzo = $_POST['prezzo'];
    $tipicamere = $_POST['tipicamere'];

    $querycamere = "SELECT * FROM Camere";
    $querycamere_result = $conn->query($querycamere);
    if (!$querycamere_result) {
        echo("Errore nella query");
    } else {
        $row_camere = $querycamere_result->fetch_array();
        $f = false;
        while ($row_camere != null) {
            if ($numero === $row_camere['Numero']) {
                $f = true;
            }
            $row_camere = $querycamere_result->fetch_array();
        }
        if (!$f) {

            $querycamerains = "INSERT INTO Camere(Numero, Prezzo, idTipoCamera) VALUES ('$numero', '$prezzo', '$tipicamere')";
            $querycamerains_result = $conn->query($querycamerains);
            if (!$querycamerains_result) {
                echo("Errore nella query");
            } else {
                echo("Camera inserita correttamente");
            }
        } else {
            echo("Inserita una Camera con numero esistente, riprovare cambiando numero!");
        }

    }
    ?>
    <form action="insert_camere.php">
        <br>Torna all'inserimento delle Camere&nbsp;<input type="submit" value="Vai">
    </form>
    <form action="<?= $urlportale ?>">
        Torna al portale&nbsp;<input type="submit" value="Vai">
    </form>
    <?php
}
?>
</body>
</html>

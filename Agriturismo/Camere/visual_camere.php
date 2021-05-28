<html>
<head>
    <title>Camere</title>
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
        $utente = "Cliente";
        $urlportale = "../portale.php";
        break;
    case "Dipendente":
        $utente = "Dipendente";
        $urlportale = "../portaledip.php";
        break;
    case "Amministratore":
        $utente = "Amministratore";
        $urlportale = "../portaleadmin.php";
        break;
    default :
        $utente = "Errore";
        $urlportale = "../hub.html";
        break;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idcamere = $_POST['idcamere'];

    $querycancellacamera = "DELETE FROM Camere WHERE idCamere = '$idcamere'";
    $querycancellacamera_result = $conn->query($querycancellacamera);
    if (!$querycancellacamera_result) {
        echo("Errore nella query");
    } else {
        ?>
        Camera cancellata correttamente <br>
        <form method="get" action="">
            Torna alla visualizzazione delle Camere<input type="submit" value="Vai">
        </form>
        <form action="<?= $urlportale ?>">
            Torna al portale<input type="submit" value="Vai">
        </form>
        <?php
    }
} else {
$querycamere = "SELECT * FROM Camere INNER JOIN TipiCamere ON Camere.idTipoCamera = TipICamere.idTipiCamere ORDER BY Camere.idCamere";
$querycamere_result = $conn->query($querycamere);
if ($querycamere_result->num_rows == 0) {
    echo("Nessuna Camera trovata");
} else {
?>
<table border="1">
    <tr>
        <td>Numero</td>
        <td>Prezzo</td>
        <td>Tipo Camera</td>
    </tr>
    <tr>
        <?php
        $row_camere = $querycamere_result->fetch_array();
        while ($row_camere != null) {
            echo("<td>$row_camere[Numero]</td><td>$row_camere[Prezzo]</td><td>$row_camere[Nome]</td>");
            if ($utente == "Amministratore") {
                ?>
                <form method="post" action="">
                    <td>
                        <input type="submit" value="Cancella">
                        <input type="text" name="idcamere" value="<?= $row_camere['idCamere'] ?>" hidden>
                    </td>
                </form>
                <?php
            } else if ($utente == "Cliente") {
                ?>
                <form method="post" action="prenotazioni_camere.php">
                    <td>
                        <input type="submit" value="Vai alla prenotazione">
                        <input type="text" name="idcamera" value="<?= $row_camere['idCamere'] ?>" hidden>
                    </td>
                </form>
                <?php
            }
            echo("</tr>");
            $row_camere = $querycamere_result->fetch_array();
        }
        echo("</table><br><br>");
        }
        ?>
        <form action="<?= $urlportale ?>">
            Torna al portale agriturismo&nbsp;<input type="submit" value="Vai">
        </form>
        <?php
        }
        }
        ?>
</body>
</html>

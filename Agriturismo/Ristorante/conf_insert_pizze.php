<html>
<head>
    <title>Inserisci Pizza</title>
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

    $nome = $_POST['nome'];
    $descrizione = $_POST['descrizione'];
    $prezzo = $_POST['prezzo'];

    $querypizzains = "INSERT INTO Pizze(Nome, Descrizione, Prezzo) VALUES ('$nome', '$descrizione', '$prezzo')";
    $querypizzains_result = $conn->query($querypizzains);
    if (!$querypizzains_result) {
        echo("Errore nella query");
    } else {
        echo("Pizza inserita correttamente");
    }
    ?>
    <form action="insert_pizze.php">
        <br>Torna all'inserimento delle Pizze&nbsp;<input type="submit" value="Vai">
    </form>
    <form action="<?= $urlportale ?>">
        Torna al portale&nbsp;<input type="submit" value="Vai">
    </form>
    <?php
}
?>
</body>
</html>
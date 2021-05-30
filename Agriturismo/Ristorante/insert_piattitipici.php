<html>
<head>
    <title>Inserisci Piatto Tipico</title>
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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome = $_POST['nome'];
        $descrizione = $_POST['descrizione'];
        $prezzo = $_POST['prezzo'];
        echo("Vuoi inserire davvero il piatto tipico di nome $nome, descrizione $descrizione e prezzo $prezzo?");
        ?>
        <form action="conf_insert_piattitipici.php" method="post">
            <input type="submit" value="Inserisci">
            <input type="text" name="nome" value="<?= $nome ?>" hidden>
            <input type="text" name="descrizione" value="<?= $descrizione ?>" hidden>
            <input type="text" name="prezzo" value="<?= $prezzo ?>" hidden>
        </form>
        <?php
    } else {
        ?>
        Inserisci un Piatto Tipico:<br>
        <form method="post" action="">
            <br>Nome:&nbsp;<input type="text" name="nome">
            <br>Descrizione:&nbsp;<input type="text" name="descrizione">
            <br>Prezzo:&nbsp;<input type="text" name="prezzo">
            <br><input type="submit" value="Inserisci">
        </form>
        <?php
    }
    ?>
    <form action="<?= $urlportale ?>">
        Torna al portale&nbsp;<input type="submit" value="Vai">
    </form>
    <?php
}
?>
</body>
</html>
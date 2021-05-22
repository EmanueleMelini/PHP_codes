<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST' || !array_key_exists("HTTP_REFERER", $_SERVER)) {
    session_destroy();
    header("Location: http://localhost/Login/Agriturismo/hub.html");
} else {
    echo("Benvenuto $_SESSION[Nome] $_SESSION[Cognome]");
    ?>
    <html>
    <head>
        <title>Portale Amministratori Agriturismo</title>
    </head>
    <body>
    <form action="visual_menu_piattitipici.php">
        <br>Visualizza il Menu dei Piatti Tipici&nbsp;<input type="submit" value="Vai">
    </form>
    <form action="insert_piattitipici.php">
        Inserisci Piatti Tipici&nbsp;<input type="submit" value="Vai">
    </form>
    <form action="visual_menu_pizze.php">
        Visualizza il Menu delle pizze&nbsp;<input type="submit" value="Vai">
    </form>
    <form action="insert_pizze.php">
        Inserisci Pizze&nbsp;<input type="submit" value="Vai">
    </form>
    <form action="visual_prenotazioni_cibi.php">
        Visualizza Prenotazioni Cibi&nbsp;<input type="submit" value="Vai">
    </form>
    <form action="visual_escursioni.php">
        <br>Visualizza le Escursioni&nbsp;<input type="submit" value="Vai">
    </form>
    <form action="insert_escursioni.php">
        Inserisci Escursioni&nbsp;<input type="submit" value="Vai">
    </form>
    <form action="visual_prenotazioni_escursioni.php">
        Visualizza Prenotazioni Escursioni&nbsp;<input type="submit" value="Vai">
    </form>
    <form action="visual_attivitaippiche.php">
        <br>Visualizza le Attività Ippiche&nbsp;<input type="submit" value="Vai">
    </form>
    <form action="insert_attivitaippiche.php">
        Inserisci Attività Ippiche&nbsp;<input type="submit" value="Vai">
    </form>
    <form action="visual_prenotazioni_attivitaippiche.php">
        Visualizza Prenotazioni Attività Ippiche&nbsp;<input type="submit" value="Vai">
    </form>
    <form action="visual_camere.php">
        <br>Visualizza le Camere&nbsp;<input type="submit" value="Vai">
    </form>
    <form action="insert_camere.php">
        Inserisci Camere&nbsp;<input type="submit" value="Vai">
    </form>
    <form action="visual_prenotazioni_soggiorni.php">
        Visualizza Prenotazioni Soggiorni&nbsp;<input type="submit" value="Vai">
    </form>

    <br><br><br>
    <form action="" method="post">
        Logout&nbsp;<input type="submit" value="Vai">
    </form>
    </body>
    </html>
    <?php
}
?>
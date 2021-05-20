<?php
//TODO: Cambiare il portale per i dipendenti
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST' || !array_key_exists("HTTP_REFERER", $_SERVER)) {
    session_destroy();
    header("Location: http://localhost/Login/Agriturismo/hub.html");
} else {
    echo("Benvenuto " . $_SESSION['Nome'] . " " . $_SESSION['Cognome']);
    ?>
    <html>
    <head>
        <title>Portale Agriturismo</title>
    </head>
    <body>
    <form action="visual_menu_piattitipici.php">
        <br>Visualizza il Menu dei piatti tipici&nbsp;<input type="submit" value="Vai">
    </form>
    <form action="visual_menu_pizze.php">
        Visualizza il Menu delle pizze&nbsp;<input type="submit" value="Vai">
    </form>
    <form action="visual_escursioni.php">
        Visualizza le escursioni&nbsp;<input type="submit" value="Vai">
    </form>
    <form action="visual_attivitaippiche.php">
        Visualizza le attività ippiche&nbsp;<input type="submit" value="Vai">
    </form>
    <form action="prenotazioni_piattitipici.php">
        Prenota piatti tipici&nbsp;<input type="submit" value="Vai">
    </form>
    <form action="prenotazioni_pizze.php">
        Prenota Pizze&nbsp;<input type="submit" value="Vai">
    </form>
    <form action="visual_prenotazioni_cibi.php">
        Visualizza Prenotazioni Cibi&nbsp;<input type="submit" value="Vai">
    </form>
    <form action="prenotazioni_camere.php">
        Prenota Camere&nbsp;<input type="submit" value="Vai">
    </form>
    <form action="visual_prenotazioni_soggiorni.php">
        Visualizza Prenotazioni Soggiorni&nbsp;<input type="submit" value="Vai">
    </form>
    <form action="prenotazioni_escursioni.php">
        Prenota Escursioni&nbsp;<input type="submit" value="Vai">
    </form>
    <form action="visual_prenotazioni_escursioni.php">
        Visualizza Prenotazioni Escursioni&nbsp;<input type="submit" value="Vai">
    </form>
    <form action="prenotazioni_attivitaippiche.php">
        Prenota Attività Ippiche&nbsp;<input type="submit" value="Vai">
    </form>
    <form action="visual_prenotazioni_attivitaippiche.php">
        Visualizza Prenotazioni Attività Ippiche&nbsp;<input type="submit" value="Vai">
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
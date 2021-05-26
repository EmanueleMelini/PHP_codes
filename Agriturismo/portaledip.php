<?php
//TODO:
// controllare errore sql inserimento '
// sistemare la visualizzazione html con chiusura dei tag php
// creare query che elimina le prenotazioni con data attuale maggiore
// cambiare sistema attività ippiche mettere fascia oraria prestabilita non inserimento
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST' || !array_key_exists("HTTP_REFERER", $_SERVER)) {
    session_destroy();
    header("Location: http://localhost/Login/Agriturismo/hub.html");
} else {
    echo("Benvenuto " . $_SESSION['Nome'] . " " . $_SESSION['Cognome']);
    ?>
    <html>
    <head>
        <title>Portale Dipendenti Agriturismo</title>
    </head>
    <body>
    <form action="Ristorante/visual_menu_piattitipici.php">
        <br>Visualizza il Menu dei Piatti Tipici&nbsp;<input type="submit" value="Vai">
    </form>
    <form action="Ristorante/insert_piattitipici.php">
        Inserisci Piatti Tipici&nbsp;<input type="submit" value="Vai">
    </form>
    <form action="Ristorante/visual_menu_pizze.php">
        Visualizza il Menu delle pizze&nbsp;<input type="submit" value="Vai">
    </form>
    <form action="Ristorante/insert_pizze.php">
        Inserisci Pizze&nbsp;<input type="submit" value="Vai">
    </form>
    <form action="Ristorante/visual_prenotazioni_cibi.php">
        Visualizza Prenotazioni Cibi&nbsp;<input type="submit" value="Vai">
    </form>
    <form action="Escursioni/visual_escursioni.php">
        <br>Visualizza le Escursioni&nbsp;<input type="submit" value="Vai">
    </form>
    <form action="Escursioni/insert_escursioni.php">
        Inserisci Escursioni&nbsp;<input type="submit" value="Vai">
    </form>
    <form action="Escursioni/visual_prenotazioni_escursioni.php">
        Visualizza Prenotazioni Escursioni&nbsp;<input type="submit" value="Vai">
    </form>
    <form action="AttivitaIppiche/visual_attivitaippiche.php">
        <br>Visualizza le Attività Ippiche&nbsp;<input type="submit" value="Vai">
    </form>
    <form action="AttivitaIppiche/insert_attivitaippiche.php">
        Inserisci Attività Ippiche&nbsp;<input type="submit" value="Vai">
    </form>
    <form action="AttivitaIppiche/visual_prenotazioni_attivitaippiche.php">
        Visualizza Prenotazioni Attività Ippiche&nbsp;<input type="submit" value="Vai">
    </form>
    <form action="Camere/visual_camere.php">
        <br>Visualizza le Camere&nbsp;<input type="submit" value="Vai">
    </form>
    <form action="Camere/insert_camere.php">
        Inserisci Camere&nbsp;<input type="submit" value="Vai">
    </form>
    <form action="Camere/visual_prenotazioni_soggiorni.php">
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
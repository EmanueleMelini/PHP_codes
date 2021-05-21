<html>
<head>
    <title>Inserisci Camere</title>
</head>
<body>
<?php

if (!array_key_exists("HTTP_REFERER", $_SERVER)) {
    session_destroy();
    header("Location: http://localhost/Login/Agriturismo/hub.html");
} else {
    session_start();
    require 'agriturismo_connect.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $numero = $_POST['numero'];
        $prezzo = $_POST['prezzo'];
        $maxpersone = $_POST['maxpersone'];
        echo("Vuoi inserire davvero la camera numero $numero, prezzo $prezzo e massimo persone $maxpersone?");
        echo("
<form action='conf_insert_camere.php' method='post'>
    <input type='submit' value='Inserisci'>
    <input type='text' name='numero' value='$numero' hidden>
    <input type='text' name='prezzo' value='$prezzo' hidden>
    <input type='text' name='maxpersone' value='$maxpersone' hidden>
</form>");
    } else {
        echo("Inserisci una camera:<br>");
        echo("<form method='post' action=''>");
        echo("<br>Numero:&nbsp;<input type='number' name='numero'>");
        echo("<br>Prezzo:&nbsp;<input type='number' name='prezzo'>");
        echo("<br>Massimo Persone:&nbsp;<input type='number' name='maxpersone'>");
        echo("<br><input type='submit' value='Inserisci'></form>");
    }
}
?>
<form action="portaledip.php">
    Torna al portale&nbsp;<input type="submit" value="Vai">
</form>
</body>
</html>

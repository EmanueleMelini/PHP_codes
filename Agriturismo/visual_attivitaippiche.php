<html>
<head>
    <title>Attività Ippiche</title>
</head>
<body>
<?php
if (!array_key_exists("HTTP_REFERER", $_SERVER)) {
    header("Location: http://localhost/Login/Agriturismo/hub.html");
} else {
    require 'agriturismo_connect.php';
    session_start();
    $queryattivitaippiche = "SELECT * FROM AttivitaIppiche";
    $queryattivitaippiche_result = $conn->query($queryattivitaippiche);
    if ($queryattivitaippiche_result->num_rows == 0) {
        echo("Nessuna pizza nel menu");
    } else {
        echo("<table border='1'><tr><td>Nome Escursione</td><td>Nome Cavallo</td></tr><tr>");
        $row_menu = $queryattivitaippiche_result->fetch_array();
        while ($row_menu != null) {
            echo("<td>$row_menu[Nome]</td><td>$row_menu[NomeCavallo]</td></tr>");
            $row_menu = $queryattivitaippiche_result->fetch_array();
        }
    }
}
?>
</table>
<br><br>
<form action="portale.php">
    Torna al portale agriturismo&nbsp;<input type="submit" value="Vai">
</form>
</body>
</html>

<html>
<head>
    <title>Camere</title>
</head>
<body>
<?php
if (!array_key_exists("HTTP_REFERER", $_SERVER)) {
    header("Location: http://localhost/Login/Agriturismo/hub.html");
} else {
    require 'agriturismo_connect.php';
    session_start();
    if ($_SESSION['Tipo'] === "Cliente") {
        $utente = "Cliente";
    } else {
        $utente = "Dipendente";
    }
    $queryescursioni = "SELECT * FROM Camere";
    $queryescursioni_result = $conn->query($queryescursioni);
    if ($queryescursioni_result->num_rows == 0) {
        echo("Nessuna pizza nel menu");
    } else {
        echo("<table border='1'><tr><td>Numero</td><td>Prezzo</td><td>Max Persone</td><td>Prenotata</td><tr>");
        $row_menu = $queryescursioni_result->fetch_array();
        while ($row_menu != null) {
            echo("<td>$row_menu[Numero]</td><td>$row_menu[Prezzo]</td><td>$row_menu[MaxPersone]</td>");
            if($row_menu['Ordinata'] == 0) {
                echo("<td>No</td>");
            } else {
                echo("<td>Si</td>");
            }
            echo("</tr>");
            $row_menu = $queryescursioni_result->fetch_array();
        }
        echo("</table><br><br>");
    }
    if($utente === "Cliente") {
        echo("<form action='portale.php'>");
    } else {
        echo("<form action='portaledip.php'>");
    }
}
?>
    Torna al portale agriturismo&nbsp;<input type="submit" value="Vai">
</form>
</body>
</html>

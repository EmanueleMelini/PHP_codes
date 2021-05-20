<html>
<head>
    <title>Escursioni</title>
</head>
<body>
<?php
if (!array_key_exists("HTTP_REFERER", $_SERVER)) {
    header("Location: http://localhost/Login/Agriturismo/hub.html");
} else {
    require 'agriturismo_connect.php';
    session_start();
    $queryescursioni = "SELECT * FROM Escursioni";
    $queryescursioni_result = $conn->query($queryescursioni);
    if ($queryescursioni_result->num_rows == 0) {
        echo("Nessuna pizza nel menu");
    } else {
        echo("<table border='1'><tr><td>Nome Escursione</td><td>Meta</td></tr><tr>");
        $row_menu = $queryescursioni_result->fetch_array();
        while ($row_menu != null) {
            echo("<td>$row_menu[Nome]</td><td>$row_menu[Meta]</td></tr>");
            $row_menu = $queryescursioni_result->fetch_array();
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

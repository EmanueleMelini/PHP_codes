<html>
<head>
    <title>Piatti Tipici</title>
</head>
<body>
<?php
require 'agriturismo_connect.php';
session_start();
$querymenu = "SELECT * FROM PiattiTipici";
$querymenu_result = $conn->query($querymenu);
if ($querymenu_result->num_rows == 0) {
    echo("Nessun piatto tipico nel menu");
} else {
    echo("<table border='1'><tr><td>Nome Piatto</td><td>Descrizione Piatto</td><td>Prezzo Piatto</td></tr><tr>");
    $row_menu = $querymenu_result->fetch_array();
    while ($row_menu != null) {
        echo("<td>$row_menu[Nome]</td><td>$row_menu[Descrizione]</td><td>$row_menu[Prezzo] euro</td></tr>");
        $row_menu = $querymenu_result->fetch_array();
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

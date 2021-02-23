<?php
require 'community_connect.php';
$query_select_user = "select * from utenti";


$tipo = 1;
while ($tipo <= 3) {
    $query_result_select = $conn->query($query_select_user);
    if (!$query_result_select) {
        echo("Errore nella query");
    } else {
        $row = $query_result_select->fetch_array();
        if ($tipo == 1) echo("Studenti:<br>");
        else if ($tipo == 2) echo("Docenti:<br>");
        else echo("Admin:<br>");
        while ($row != null) {
            if ($tipo == $row["tipo"]) {
                echo("$row[nome] $row[cognome] $row[scuola] $row[citta] $row[email]<br>");
            }
            $row = $query_result_select->fetch_array();
        }
        $tipo++;
    }
}
?>

<form action="index.html">
    <input type="submit" value="Home">
</form>

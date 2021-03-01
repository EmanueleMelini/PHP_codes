<?php
require 'community_connect.php';
$query_select_user = "select * from utenti";

$scuola = false;
$citta = false;
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
                $query_scuola = "select * from scuole where keysc = $row[scuola]";
                $queryresult_scuola = $conn->query($query_scuola);
                $row_scuola = $queryresult_scuola->fetch_array();
                if($row_scuola != null) {
                    $scuola = true;
                }
                $query_citta = "select * from citta where keyc = $row[citta]";
                $queryresult_citta = $conn->query($query_citta);
                $row_citta = $queryresult_citta->fetch_array();
                if($row_citta != null) {
                    $citta = true;
                }

                echo ("Nome :$row[nome], ");
                echo ("Cognome :$row[cognome], ");
                if($scuola) {
                    echo("Scuola :$row_scuola[nome], ");
                }

                if($citta) {
                    echo("Citta :$row_citta[nome], ");
                }
                echo ("Email :$row[email] <br>");
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

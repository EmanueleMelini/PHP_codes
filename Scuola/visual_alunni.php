<html>
<head>
    <link rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
          integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z"
          crossorigin="anonymous"/>
    <title>Home Scuola</title>
</head>
<body>
<?php
require 'scuola_connect.php';

$query_classi = "select * from classi";

$queryresult_classi = $conn->query($query_classi);
if (!$queryresult_classi) {
    echo("Errore nella query");
} else {
    $row_classi = $queryresult_classi->fetch_array();
    while ($row_classi != null) {
        $query_alunni = "select * from alunni where alunni.keyc = '$row_classi[keyc]'";
        $queryresult_alunni = $conn->query($query_alunni);
        if (!$queryresult_alunni) {
            echo("Errore nella query");
        } else {
            echo("<br>Classe: $row_classi[nome]<br>");
            $row_alunni = $queryresult_alunni->fetch_array();
            while ($row_alunni != null) {
                echo("Alunno: $row_alunni[nome] $row_alunni[cognome] <br>");
                $row_alunni = $queryresult_alunni->fetch_array();
            }
            $row_classi = $queryresult_classi->fetch_array();
        }
    }
}
?>
<br>
<form action="home.html">
<input type="submit" value="Home">
</form>
</body>
</html>

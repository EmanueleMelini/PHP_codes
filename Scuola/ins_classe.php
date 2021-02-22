<?php
require 'scuola_connect.php';

$nome = $_POST["nome"];
echo($nome );
$query_insert = "insert into classi(nome) values('$nome')";
$queryresult = $conn->query($query_insert);
if (!$queryresult) {
    echo("Errore nella query");
} else {
    header("Location: http://localhost/Login/Scuola/home.html");
}
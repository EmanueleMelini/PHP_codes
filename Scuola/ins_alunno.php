<?php
require 'scuola_connect.php';

$nome = $_POST["nome"];
$cognome = $_POST["cognome"];
$classe = $_POST["classe"];

$query_insert = "INSERT INTO alunni(nome, cognome, keyc) 
VALUES ('$nome', '$cognome', '$classe')";
$queryresult = $conn->query($query_insert);
if (!$queryresult) {
    echo("Errore nella query");
} else {
    header("Location: http://localhost/Login/Scuola/home.html");
}
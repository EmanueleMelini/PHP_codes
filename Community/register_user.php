<?php
require 'community_connect.php';
$nome = $_POST["nome"];
$cognome = $_POST["cognome"];
$scuola = $_POST["scuola"];
$citta = $_POST["citta"];
$email = $_POST["email"];
$password = $_POST['password'];
$tipo = $_POST["tipo"];

$query_insert_user = "INSERT INTO utenti(nome, cognome, scuola, citta, email, tipo, password)
VALUES('$nome', '$cognome', '$scuola', '$citta', '$email', '$tipo', '$password')";
$query_result_user = $conn->query($query_insert_user);
if(!$query_result_user) {
    echo ("Errore nella query");
} else {
    echo ("Utente Inserito correttamente");
}
?>
<form action="index.html">
    <input type="submit" value="Home">
</form>
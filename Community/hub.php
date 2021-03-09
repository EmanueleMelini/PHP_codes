<html>
<head>
    <link rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
          integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z"
          crossorigin="anonymous"/>
    <title>Home</title>
</head>
<body>
<?php
require 'community_connect.php';
$email = $_POST['email'];
$password = $_POST['password'];

$query_utente = "select * from utenti where (email = '$email' and password = '$password')";
$queryresult_utente = $conn->query($query_utente);
if (!$queryresult_utente) {
    echo("Errore nella query utente");
} else {
    $row_utente = $queryresult_utente->fetch_array();
    $nome = $row_utente['nome'];
    $cognome = $row_utente['cognome'];
    $tipo = $row_utente['tipo'];
    $classeid = $row_utente['citta'];
    $scuolaid = $row_utente['scuola'];

    $query_scuola = "select * from scuole where keysc = $scuolaid";
    $query_citta = "select * from citta where keyc = $classeid";

    $queryresult_scuola = $conn->query($query_scuola);
    $queryresult_citta = $conn->query($query_citta);
    $scuolaf = false;
    $cittaf = false;

    if (!$queryresult_scuola) {
        echo("Errore nella query scuola");
    } else {
        $scuolaf = true;
    }

    if (!$queryresult_citta) {
        echo("Errore nela query citta");
    } else {
        $cittaf = true;
    }

    $scuola = "Nessuna";
    if ($scuolaf) {
        $row_scuola = $queryresult_scuola->fetch_array();
        $scuola = $row_scuola['nome'];
    }

    $citta = "Nessuna";
    if ($cittaf) {
        $row_citta = $queryresult_citta->fetch_array();
        $citta = $row_citta['nome'];
    }

    $tipos = "Nessuno";
    if ($tipo == 1) {
        $tipos = "Studente";
    } else if ($tipo == 2) {
        $tipos = "Docente";
    } else if ($tipo == 3) {
        $tipos = "Admin";
    }

    echo("Correttamente loggato come:<br>Nome: $nome, Cognome: $cognome, Scuola: $scuola, Citta: $citta, Tipo: $tipos, Email: $email");

    echo("<form action='insert_document.php' method='post'>");
    echo("<input type='text' hidden value='$row_utente[keyu]' name='keyu'>");
    echo("<input type='text' hidden value='$tipo' name='tipo'>");
    echo("<input type='text' hidden value='$email' name='email'>");
    echo("<input type='text' hidden value='$password' name='password'>");
    echo("<input type='submit' value='Upload Documento'>");
    echo("</form>");
}
?>

<form action="index.html">
    <input type="submit" value="Home">
</form>


</body>
</html>
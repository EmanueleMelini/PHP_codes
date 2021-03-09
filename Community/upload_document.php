<?php
require 'community_connect.php';

$titolo = $_POST['titolo'];
$tipo_doc = $_POST['tipo_doc'];
$descrizione = $_POST['descrizione'];
$data = $_POST['data'];
$keyu = $_POST['keyu'];
$tipo = $_POST['tipo'];
$email = $_POST['email'];
$password = $_POST['password'];

$query_documento = "INSERT INTO documenti (titolo, tipo_doc, descrizione, data_upload, tipo_utente, keyu)
VALUES ('$titolo', '$tipo_doc', '$descrizione', '$data', '$tipo', '$keyu')";
$queryresult_documento = $conn->query($query_documento);

if(!$queryresult_documento) {
    echo ("Errore nella query");
} else {
    echo ("Insert corretto");
    echo ("<form action='hub.php' method='post'>");
    echo ("<input type='email' hidden name='email' value='$email'>");
    echo ("<input type='password' hidden name='password' value='$password'>");
    echo ("<input type='submit' value='Vai alla Hub'>");
    echo ("</form>");
}
?>
<html>
<head>
    <title>Upload Documenti</title>
</head>
<body>
<form action="index.html">
    <input type="submit" value="Home">
</form>
</body>
</html>

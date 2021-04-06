<?php
require 'community_connect.php';
session_start();
$titolo = $_FILES["documento"]["name"];
//$tipo_doc = $_FILES["documento"]["type"];
$descrizione = $_POST['descrizione'];
$oldpath = $_FILES["documento"]["tmp_name"];
$path = "D:/Wamp/www/Files/".$titolo;
$data = $_SESSION['data_upload'];
$keyu = $_SESSION['keyu'];
$tipo = $_SESSION['tipo'];
$email = $_SESSION['email'];
$password = $_SESSION['password'];

$controllo = move_uploaded_file($oldpath, $path);
if(!$controllo)
    echo "Errore";
else {
    echo "Upload effettuato correttamente";
    $newpath = $path;
    /*
    $titolo = $_POST['titolo'];
    $tipo_doc = $_POST['tipo_doc'];
    $descrizione = $_POST['descrizione'];
    $data = $_POST['data'];
    $keyu = $_POST['keyu'];
    $tipo = $_POST['tipo'];
    $email = $_POST['email'];
    $password = $_POST['password'];*/
    echo "<br>$titolo<br>$newpath<br>$descrizione<br>$data<br>$tipo<br>$keyu";
    //$tipo_doc<br>
    $query_documento = "INSERT INTO documenti (titolo, /*tipo_doc,*/ path, descrizione, data_upload, tipo_utente, keyu)
        VALUES ('$titolo', '$newpath', '$descrizione', '$data', '$tipo', '$keyu')";
    //$tipo_doc', '
    $queryresult_documento = $conn->query($query_documento);

    if (!$queryresult_documento) {
        echo("Errore nella query");
    } else {
        /*echo("Insert corretto");
        echo("<form action='hub.php' method='post'>");
        echo("<input type='email' hidden name='email' value='$email'>");
        echo("<input type='password' hidden name='password' value='$password'>");
        echo("<input type='submit' value='Vai alla Hub'>");
        echo("</form>");*/
        $_SESSION["email"] = $email;
        $_SESSION["password"] = $password;
        header("Location: http://localhost/Login/Community/hub.php");
    }
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

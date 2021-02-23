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

$nome = $_POST["nome"];
$query_insert = "insert into classi(nome) values('$nome')";
$queryresult = $conn->query($query_insert);
if (!$queryresult) {
    echo("Errore nella query");
} else {
    echo ("Classe inserita correttamente");
    #header("Location: http://localhost/Login/Scuola/home.html");
}
?>
<form action="home.html">
    <input type="submit" value="Home">
</form>
</body>
</html>
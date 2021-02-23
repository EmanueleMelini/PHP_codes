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
$classe = $_POST["classe"];
echo("$classe<br>");
$query_delete_classe = "DELETE FROM classi WHERE keyc = $classe";
$queryresult_delete_classe = $conn->query($query_delete_classe);
if(!$queryresult_delete_classe) {
    echo("Errore nella query");
} else {
    echo("Classe eliminata correttamente");
}
?>
<form action="home.html">
    <input type="submit" value="Home">
</form>
</body>
</html>
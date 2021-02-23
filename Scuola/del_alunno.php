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
$alunno = $_POST["alunno"];
$query_delete_alunno = "DELETE FROM alunni WHERE keya = $alunno";
$queryresult_delete_alunno = $conn->query($query_delete_alunno);
if(!$queryresult_delete_alunno) {
    echo("Errore nella query");
} else {
    echo ("Alunno eliminato correttamente");
}
?>
<form action="home.html">
    <input type="submit" value="Home">
</form>
</body>
</html>

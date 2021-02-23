<html>
<head>
    <link rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
          integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z"
          crossorigin="anonymous"/>
    <title>Controllo login</title>
</head>
<body>
<form action="del_alunno.php" method="post">
    <select name="alunno">
        <option value="">-</option>
<?php
require 'scuola_connect.php';
$query = "select alunni.keya, classi.keyc, alunni.nome, alunni.cognome, classi.nome as classe from alunni, classi where alunni.keyc = classi.keyc";
$queryresult = $conn->query($query);
if (!$queryresult) {
    echo("Errore nella query");
} else {
    $row = $queryresult->fetch_array();
    while ($row != null) {
        echo("<option value='$row[keya]'>$row[classe] - $row[nome] $row[cognome]</option>");
        $row = $queryresult->fetch_array();
    }
}
?>
    </select>
    <input type="submit" value="Elimina">
</form>
<form action="home.html">
    <input type="submit" value="Home">
</form>
</body>
</html>

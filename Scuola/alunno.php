<html>
<head>
    <link rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
          integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z"
          crossorigin="anonymous"/>
    <title>Controllo login</title>
</head>
<body>
<form method="post" action="ins_alunno.php">
    <?php
    require 'scuola_connect.php';

    echo ("<br>Nome&nbsp;<input type='text' name='nome'><br>")
        . ("Cognome&nbsp;<input type='text' name='cognome'><br>")
        . ("Classe&nbsp;<select name='classe'>")
        . ("<option value=''>-</option>");

    $query1 = "select * from classi";
    $queryresult = $conn->query($query1);
    if (!$queryresult) {
        echo("Errore nella query");
    } else {
        $row = $queryresult->fetch_array();
        while ($row != null) {
            echo("<option value='$row[keyc]'>$row[keyc] - $row[nome]</option>");
            $row = $queryresult->fetch_array();
        }
        echo("</select><br>");
    }
    ?>
    <input type="submit" value="Inserisci"><br>
</form>
<form action="home.html">
    <input type="submit" value="Home">
</form>
</body>
</html>
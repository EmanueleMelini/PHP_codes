<html>
<head>
    <link rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
          integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z"
          crossorigin="anonymous"/>
    <title>Controllo login</title>
</head>
<body>
<form action="del_classe.php" method="post">
    <select name="classe">
        <option value="">-</option>
        <?php
        require 'scuola_connect.php';
        $query = "select * from classi";
        $queryresult = $conn->query($query);
        if (!$queryresult) {
            echo("Errore nella query");
        } else {
            $row = $queryresult->fetch_array();
            while ($row != null) {
                echo("<option value='$row[keyc]'>$row[keyc] - $row[nome]</option>");
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
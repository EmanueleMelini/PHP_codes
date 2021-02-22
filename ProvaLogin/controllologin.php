<html>
<head>
    <link rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
          integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z"
          crossorigin="anonymous"/>
    <title>Controllo login</title>
</head>
<body>
<table border="1">
    <tr>
        <td>
            <?php
            require 'connetti.php';

            $username = $_POST["username"];
            $password = $_POST["password"];

            echo ("Credenziali inserite<br>")
                . ("Username: $username<br>Password: $password")
                . ("</td>")
                . ("</tr>")
                . ("<tr>")
                . ("<td>");

            $query1 = "select * from dati";
            $queryresult = $conn->query($query1);
            if (!$queryresult) {
                echo("Errore nella query");
            } else {
                echo("<br>numero righe $queryresult->num_rows");
                $row = $queryresult->fetch_array();
                while ($row != null) {
                    echo("<br><br>Username: $row[username]<br>Password: $row[password]");
                    if ($username == $row['username'] && $password == $row['password']) {
                        echo("<br>Credenziali giuste");
                    } else {
                        echo("<br>Credenziali errate");
                    }

                    $row = $queryresult->fetch_array();
                }
            }
            ?>
        </td>
    </tr>
</table>
</body>
</html>
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
            $log = false;
            if (!$queryresult) {
                echo("Errore nella query");
            } else {
                echo("<br>numero righe $queryresult->num_rows");
                $row = $queryresult->fetch_array();
                while ($row != null) {
                    echo("<br><br>Username: $row[username]<br>Password: $row[password]");
                    if ($username == $row['username'] && $password == $row['password']) {
                        echo("<br>Credenziali giuste");
                        $log = true;
                    } else {
                        echo("<br>Credenziali errate");
                    }

                    $row = $queryresult->fetch_array();
                }
                if ($log) {
                    echo ("</td>")
                        . ("</tr>")
                        . ("<tr>")
                        . ("<td>")
                        . ("<form action='cambio.php' method='post'>")
                        . ("<input type='text' name='usernameold' hidden value='$username'>")
                        . ("<input type='text' name='passwordold' hidden value='$password'>")
                        . ("<input type='text' name='username' placeholder='Cambia username'>")
                        . ("<input type='password' name='password' placeholder='Cambia password'>")
                        . ("<input type='submit' name='Cambia'>")
                        . ("</form>");
                }
                echo ("</td>")
                    . ("</tr>")
                    . ("<tr>")
                    . ("<td>")
                , ("<form action='login.html'>")
                    . ("<input type='submit' value='Torna al login'><br>")
                    . ("</form>");
            }
            ?>
        </td>
    </tr>
</table>
</body>
</html>
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

            $usernameold = $_POST["usernameold"];
            $passwordold = $_POST["passwordold"];
            $username = $_POST["username"];
            $password = $_POST["password"];

            $query1 = "update dati set username = '" . $username . "', password = '" . $password . "' where username = '" . $usernameold . "' and password = '" . $passwordold . "'";
            $queryresult = $conn->query($query1);
            if (!$queryresult) {
                echo("Errore nella query " . $conn->error);
            } else {
                echo("Username e password cambiate");
            }
            $query2 = "select * from dati where username = '" . $username . "' and password = '" . $password . "'";
            $queryresult2 = $conn->query($query2);
            if (!$queryresult2) {
                echo("Errore nella query " . $conn->error);
            } else {
                $row = $queryresult2->fetch_array();
                if ($row != null) {
                    echo("<br><br>Username: $row[username]<br>Password: $row[password]");
                }
            }
            echo ("<form action='login.html'>")
                . ("<input type='submit' value='Torna al login'><br>")
                . ("</form>")
                . ("<form action='cambiopass.php' method='post'>")
                . ("<input type='text' name='username' hidden value='$username'>")
                . ("<input type='text' name='password' hidden value='$password'>")
                . ("<input type='submit' value='Torna al cambio'><br>")
                . ("</form>");
            ?>
        </td>
    </tr>
</table>
</body>
</html>
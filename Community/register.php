<html>
<head>
    <link rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
          integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z"
          crossorigin="anonymous"/>
    <title>Register</title>
</head>
<body>
<form action="register_user.php" method="post">
    Nome&nbsp;<input type="text" name="nome"><br>
    Cognome&nbsp;<input type="text" name="cognome"><br>
    Scuola&nbsp;<select name="scuola">
        <option value="">-</option>
        <?php
        require 'community_connect.php';
        $query_scuole = "select * from scuole";
        $queryresult_scuole = $conn->query($query_scuole);
        if (!$queryresult_scuole) {
            echo ("Errore nella query");
        } else {
            echo("prova");
            $row_scuole = $queryresult_scuole->fetch_array();
            while ($row_scuole != null) {
                echo("<option value='$row_scuole[keysc]'>$row_scuole[keysc] - $row_scuole[nome]</option>");
                $row_scuole = $queryresult_scuole->fetch_array();
            }
        }
        echo("</select><br>");

        $query_citta = "select * from citta";
        $queryresult_citta = $conn->query($query_citta);
        echo("Citta&nbsp;<select name='citta'>");
        echo("<option value=''>-</option>");
        if (!$queryresult_citta) {
            echo ("Errore nella query");
        } else {
            $row_citta = $queryresult_citta->fetch_array();
            while ($row_citta != null) {
                echo("<option value='$row_citta[keyc]'>$row_citta[keyc] - $row_citta[nome]</option>");
                $row_citta = $queryresult_citta->fetch_array();
            }
        }

        ?>
    </select><br>
    Email&nbsp;<input type="email" name="email"><br>
    Password&nbsp;<input type="password" name="password"><br>
    Tipo utente&nbsp;<select name="tipo">
        <option value="">-</option>
        <option value="1">Studente</option>
        <option value="2">Docente</option>
    </select><br>
    <input type="submit" value="Registra">
</form>
<form action="index.html">
    <input type="submit" value="Home">
</form>
</body>
</html>
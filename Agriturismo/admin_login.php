<?php
require 'agriturismo_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['Email'];
    $password = $_POST['Password'];

    $querylogin = "SELECT * FROM Amministratori WHERE '$email' = Email AND '$password' = Password";
    $querylogin_result = $conn->query($querylogin);
    if ($querylogin_result->num_rows == 1) {

        $row_login = $querylogin_result->fetch_array();
        session_start();
        $_SESSION['idAmministratore'] = $row_login['idAmministratori'];
        $_SESSION['Email'] = $email;
        $_SESSION['Password'] = $password;
        $_SESSION['Nome'] = $row_login['Nome'];
        $_SESSION['Cognome'] = $row_login['Cognome'];
        $_SESSION['Sesso'] = $row_login['Sesso'];
        $_SESSION['DataN'] = $row_login['DataN'];
        $_SESSION['Telefono'] = $row_login['Telefono'];
        $_SESSION['Indirizzo'] = $row_login['Indirizzo'];
        $_SESSION['Citta'] = $row_login['Citta'];
        $_SESSION['Tipo'] = "Amministratore";
        header("Location: http://localhost/Login/Agriturismo/portaleadmin.php");
    } else {
        echo("Email o password non corrette");
        echo("<form action='' method='get'><input type='submit' value='Indietro'></form>");
    }
} else {

    ?>
    <html>
    <head>
        <title>Login Clienti</title>
    </head>
    <body>
    <form action="" method="post">
        Login Amministratori<br>
        Email&nbsp;<input type="email" name="Email" placeholder="Email"><br>
        Password&nbsp;<input type="password" name="Password" placeholder="Password"><br>
        <input type="submit" value="Login">
    </form>
    <form action="hub.html">
        <input type="submit" value="Hub">
    </form>
    </body>
    </html>
    <?php
}
?>
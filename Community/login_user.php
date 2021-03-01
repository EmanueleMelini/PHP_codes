<?php
require 'community_connect.php';

$query_login = "select * from utenti";
$email = $_POST['email'];
$password = $_POST['password'];

$queryresult_login = $conn->query($query_login);
$login = false;

if(!$queryresult_login) {
    echo ("Errore nella query");
} else {
    $row_login = $queryresult_login->fetch_array();
    while ($row_login != null) {
        if ($email == $row_login['email'] && $password == $row_login['password']) {
            $login = true;
        }

        $row_login = $queryresult_login->fetch_array();
    }

    if($login) {
        echo ("login effettuato correttamente");
        echo ("<form action='hub.php' method='post'>");
        echo ("<input type='email' hidden name='email' value='$email'>");
        echo ("<input type='password' hidden name='password' value='$password'>");
        echo ("<input type='submit' value='Vai alla Hub'>");
        echo ("</form>");
    } else {
        echo("<Credenziali errate");
        echo ("<form action='login.html'>");
        echo ("<input type='submit' value='Torna al Login'>");
        echo ("</form>");
    }
}

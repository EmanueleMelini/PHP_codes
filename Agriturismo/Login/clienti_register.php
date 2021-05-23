<?php
require '../agriturismo_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['Nome'];
    $cognome = $_POST['Cognome'];
    $sesso = $_POST['Sesso'];
    $datan = $_POST['DataN'];
    $telefono = $_POST['Telefono'];
    $indirizzo = $_POST['Indirizzo'];
    $citta = $_POST['Citta'];
    $email = $_POST['Email'];
    $password = $_POST['Password'];

    $queryemailcheck = "SELECT * FROM Clienti WHERE '$email' = Email";
    $queryemailcheck_result = $conn->query($queryemailcheck);
    if ($queryemailcheck_result->num_rows == 1) {
        echo("Cliente gia' registrato");
        echo("<form action='' method='get'><input type='submit' value='Indietro'></form>");
    } else {
        $queryregister = "INSERT INTO Clienti(Nome, Cognome, Sesso, DataN, Telefono, Indirizzo, Citta, Email, Password)
VALUES('$nome', '$cognome', '$sesso', '$datan', '$telefono', '$indirizzo', '$citta', '$email', '$password')";
        $queryregister_result = $conn->query($queryregister);
        if (!$queryregister_result) {
            echo("Errore nella query");
        } else {
            echo("Cliente registrato correttamente");
        }
    }
} else {
    ?>
    <html>
    <head>
        <title>Registrazione Clienti</title>
    </head>
    <body>
    <form action="" method="post">
        Registrazione Clienti<br>
        Nome&nbsp;<input type="text" name="Nome" placeholder="Nome"><br>
        Cognome&nbsp;<input type="text" name="Cognome" placeholder="Cognome"><br>
        Sesso&nbsp;
        <select name="Sesso">
            <option value="M">M</option>
            <option value="F">F</option>
        </select><br>
        Data di nascita&nbsp;<input type="date" name="DataN"><br>
        Telefono&nbsp;<input type="tel" name="Telefono" placeholder="Telefono"><br>
        Indirizzo&nbsp;<input type="text" name="Indirizzo" placeholder="Indirizzo"><br>
        Citta&nbsp;<input type="text" name="Citta" placeholder="Citta"><br>
        Email&nbsp;<input type="email" name="Email" placeholder="Email"><br>
        Password&nbsp;<input type="password" name="Password" placeholder="Password"><br>
        Ripeti Password&nbsp;<input type="password" name="Ripassword" placeholder="Password"><br>
        <input type="submit" value="Registrati">
    </form>
    <form action="../hub.html">
        <input type="submit" value="Hub">
    </form>
    </body>
    </html>
    <?php
}
?>
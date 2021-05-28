<html>
<head>
    <title>Pizze</title>
</head>
<body>
<?php
if (!array_key_exists("HTTP_REFERER", $_SERVER)) {
    header("Location: http://localhost/Login/Agriturismo/hub.html");
} else {
require '../agriturismo_connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $totprezzo = $_POST['totprezzo'];
    $_SESSION['totprezzo'] = $totprezzo;
    $orapren = $_POST['orapren'];
    $listaid = $_POST['listaid'];
    $listanomi = $_POST['listanomi'];
    $listaidarray = explode(",", $listaid);
    $listanomiarray = explode(",", $listanomi);
    $tavolo = $_POST['tavolo'];
    $dataoggi = date("Y-m-d");
    $oraoggi = date("H:i");

    echo("Lista dell'ordine:<br>");

    for ($i = 0; $i < count($listaidarray); $i++) {
        echo("Nome: $listanomiarray[$i]<br>");
    }

    echo("Confermare l'ordine?");
    echo("<form action='conf_prenotazioni_cibi.php' method='post'>
<input type='text' value='$orapren' name='orapren' hidden>
<input type='hidden' name='tavolo' value='$tavolo'>
<input type='text' name='listaid' value='$listaid' hidden>
<input type='hidden' name='tipo' value='pizze'>
<input type='submit' value='Conferma'>
</form>");

} else {
$querymenu = "SELECT * FROM Pizze";
$querymenu_result = $conn->query($querymenu);
if ($querymenu_result->num_rows == 0) {
    echo("Nessuna pizza nel menu");
} else {
    echo("<form action='' method='post'>");
    $row_menu = $querymenu_result->fetch_array();
    $i = 0;
    while ($row_menu != null) {
        $prezzoi = "prezzo" . $i;
        $idi = "id" . $i;
        $nomei = "nome" . $i;
        echo("Nome:&nbsp;<input type='text' name='Nome' id='$nomei' value='$row_menu[Nome]' readonly>");
        echo("&nbsp;Prezzo:&nbsp;<input type='number' name='Prezzo' id='$prezzoi' value='$row_menu[Prezzo]' readonly>  euro");
        echo("<input type='hidden' name='id' id='$idi' value='$row_menu[idPizze]'>");
        echo("&nbsp;<input type='button' value='Aggiungi' onclick='addPiatto($i)'><br>");
        $row_menu = $querymenu_result->fetch_array();
        $i++;
    }
}
?>
<br>
<form action="" method="post">
    Prezzo totale:&nbsp;<input type="number" name="totprezzo" id="totprezzo" readonly>
    <input type="text" name="listaid" id="listaid" hidden>
    <input type="text" name="listanomi" id="listanomi" hidden>
    <br>Orario desiderato&nbsp;<input type="time" name="orapren" placeholder="Orario desiderato">
    <br>Tavolo&nbsp;<input type="number" name="tavolo" placeholder="Numero Tavolo">
    <br><input type="submit" value="Ordina">
</form>
<br><br>
<form action="../portale.php">
    Torna al portale agriturismo&nbsp;<input type="submit" value="Vai">
</form>
</body>

<script type="text/javascript">
    var prezzo = 0;
    var listaid = [];
    var listanomi = [];
    document.getElementById('totprezzo').value = prezzo;

    function addPiatto(i) {
        var prezzoi = "prezzo" + i;
        var idi = "id" + i;
        var nomei = "nome" + i;
        prezzo = prezzo + parseInt(document.getElementById(prezzoi).value);
        document.getElementById('totprezzo').value = prezzo;
        listaid.push(document.getElementById(idi).value);
        listanomi.push(document.getElementById(nomei).value);
        document.getElementById('listaid').value = listaid;
        document.getElementById('listanomi').value = listanomi;
    }
</script>
</html>
<?php
}
}
?>
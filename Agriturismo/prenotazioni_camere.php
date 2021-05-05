<html>
<head>
    <title>Prenota Camere</title>
</head>
<body>
<?php
require 'agriturismo_connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $totprezzo = $_POST['totprezzo'];
    $datainiziopren = $_POST['datainiziopren'];
    $datafinepren = $_POST['datafinepren'];
    $listaid = $_POST['listaid'];
    $listanum = $_POST['listanum'];
    $listaidarray = explode(",", $listaid);
    $listanumarray = explode(",", $listanum);
    $dataoggi = date("Y-m-d");
    $oraoggi = date("H:i");


    echo("Lista dell'ordine:<br>");

    for ($i = 0; $i < count($listaidarray); $i++) {
        echo("Numero stanza: $listanumarray[$i]<br>");
    }

    echo("Confermare l'ordine?");
    echo("<form action='prenota_camere.php' method='post'><input type='text' value='$datainiziopren' name='datainiziopren' hidden><input type='hidden' name='datafinepren' value='$datafinepren'><input type='text' name='listaid' value='$listaid' hidden><input type='submit' value='Conferma'></form>");

} else {
$dataoggi = date("Y-m-d");
$oraoggi = date("H:i");
$querycamere = "SELECT * FROM Camere";
$querycamere_result = $conn->query($querycamere);
if (!$querycamere_result) {
    echo("Errore nella query");
} else {
    $i = 0;
    $row_camere = $querycamere_result->fetch_array();
    while ($row_camere != null) {
        $prezzoi = "prezzo" . $i;
        $numeroi = "numero" . $i;
        $idi = "id". $i;
        echo("Numero camera:&nbsp;<input type='number' id='$numeroi' name='numero' value='$row_camere[Numero]' readonly>&nbsp;");
        echo("Prezzo camera:&nbsp;<input type='number' id='$prezzoi' name='prezzo' value='$row_camere[Prezzo]' readonly>&nbsp");
        echo("<input type='hidden' name='id' id='$idi' value='$row_camere[idCamere]'>");
        echo("Massimo persone per camera:&nbsp;<input type='number' name='maxpersone' value='$row_camere[MaxPersone]' readonly>&nbsp;");
        echo("<input type='button' value='Ordina' onclick='addCamera($i)'><br>");
        $row_camere = $querycamere_result->fetch_array();
        $i++;
    }
}
?>
<br>
<form action="" method="post">
    Prezzo totale:&nbsp;<input type="number" name="totprezzo" id="totprezzo" readonly>
    <input type="text" name="listaid" id="listaid" hidden>
    <input type="text" name="listanum" id="listanum" hidden>
    <br>Data inizio prenotazione&nbsp;<input type="date" name="datainiziopren">
    <br>Data fine prenotazione&nbsp;<input type="date" name="datafinepren">
    <br><input type="submit" value="Ordina">
</form>
<br><br>
<form action="portale.php">
    Torna al portale agriturismo&nbsp;<input type="submit" value="Vai">
</form>
</body>

<script type="text/javascript">
    var prezzo = 0;
    var listaid = [];
    var listanum = [];
    document.getElementById('totprezzo').value = prezzo;

    function addCamera(i) {
        var prezzoi = "prezzo" + i;
        var idi = "id" + i;
        var numeroi = "numero" + i;
        prezzo = prezzo + parseInt(document.getElementById(prezzoi).value);
        document.getElementById('totprezzo').value = prezzo;
        listaid.push(document.getElementById(idi).value);
        listanum.push(document.getElementById(numeroi).value);
        document.getElementById('listaid').value = listaid;
        document.getElementById('listanum').value = listanum;
    }
</script>
</html>
<?php
}
?>
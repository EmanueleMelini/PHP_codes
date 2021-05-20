<html>
<head>
    <title>Prenota Escursioni</title>
</head>
<body>
<?php
if (!array_key_exists("HTTP_REFERER", $_SERVER)) {
    header("Location: http://localhost/Login/Agriturismo/hub.html");
} else {
require 'agriturismo_connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datapren = $_POST['datapren'];
    $orainizio = $_POST['orainizio'];
    $orafine = $_POST['orafine'];
    $listaid = $_POST['listaid'];
    $listanomi = $_POST['listanomi'];
    $listaaddettiippica = $_POST['listaaddettiippica'];
    $listaidarray = explode(",", $listaid);
    $listanomiarray = explode(",", $listanomi);

    echo("Lista dell'ordine:<br>");

    for ($i = 0; $i < count($listaidarray); $i++) {
        echo("Nome: $listanomiarray[$i]<br>");
    }

    echo("Confermare l'ordine?");
    echo("<form action='conf_prenotazioni_attivita_ippiche.php' method='post'>
<input type='text' value='$datapren' name='datapren' hidden>
<input type='text' value='$orainizio' name='orainizio' hidden>
<input type='text' value='$orafine' name='orafine' hidden>
<input type='text' value='$listaid' name='listaid' hidden>
<input type='text' value='$listaaddettiippica' name='listaaddettiippica' hidden>
<input type='submit' value='Conferma'>
</form>");

} else {
$queryattivitaippiche = "SELECT * FROM AttivitaIppiche";
$queryattivitaippiche_result = $conn->query($queryattivitaippiche);
if ($queryattivitaippiche_result->num_rows == 0) {
    echo("Nessuna attività ippica disponibile");
} else {
    echo("<form action='' method='post'>");
    $row_attivitaippiche = $queryattivitaippiche_result->fetch_array();
    $i = 0;
    while ($row_attivitaippiche != null) {
        $idi = "id" . $i;
        $nomei = "nome" . $i;
        $addettoi = "addetto" . $i;
        echo("Nome:&nbsp;<input type='text' name='Nome' id='$nomei' value='$row_attivitaippiche[Nome]' readonly>");
        echo("&nbsp;Nome Cavallo:&nbsp;<input type='text' name='Meta' value='$row_attivitaippiche[NomeCavallo]' readonly>");
        echo("<input type='hidden' name='id' id='$idi' value='$row_attivitaippiche[idAttivitaIppiche]'>");
        echo("<select name='addettos' id='$addettoi'><option value='-1'> - </option>");

        $queryaddettiippica = "SELECT * FROM AddettiIppica";
        $queryaddettiippica_result = $conn->query($queryaddettiippica);
        $row_addettiippica = $queryaddettiippica_result->fetch_array();
        while ($row_addettiippica != null) {
            echo("<option value='$row_addettiippica[idAddettiIppica]'>$row_addettiippica[Nome] $row_addettiippica[Cognome]</option>");
            $row_addettiippica = $queryaddettiippica_result->fetch_array();
        }
        echo("</select>&nbsp;<input type='button' value='Aggiungi' onclick='addEscursione($i)'><br>");
        $row_attivitaippiche = $queryattivitaippiche_result->fetch_array();
        $i++;
    }
}
?>
</table>
<br>
<form action="" method="post">
    Numero Attività Ippiche:&nbsp;<input type="number" name="numatt" id="numatt" readonly>
    <input type="text" name="listaid" id="listaid" hidden>
    <input type="text" name="listanomi" id="listanomi" hidden>
    <input type="text" name="listaaddettiippica" id="listaaddettiippica" hidden>
    <br>Data desiderata&nbsp;<input type="date" name="datapren">
    <br>Ora inizio&nbsp;<input type="time" name="orainizio">
    <br>Ora fine&nbsp;<input type="time" name="orafine">
    <br><input type="submit" value="Ordina">
</form>
<br><br>
<form action="portale.php">
    Torna al portale agriturismo&nbsp;<input type="submit" value="Vai">
</form>
</body>

<script type="text/javascript">
    var listaid = [];
    var listanomi = [];
    var listaaddettiippica = [];
    var num = 0;
    var listaattivitaordinate = [];

    function addEscursione(i) {
        var idi = "id" + i;
        var nomei = "nome" + i;
        var addettoi = "addetto" + i;
        var idattivitaippica = document.getElementById(idi).value;
        //TODO:  correggere errore;
        if (document.getElementById(addettoi).value === "-1") {
            alert("Scegli un addetto ippica!");
        } else {
            if (listaattivitaordinate.indexOf(idattivitaippica) === -1) {
                listaid.push(document.getElementById(idi).value);
                listanomi.push(document.getElementById(nomei).value);
                listaaddettiippica.push(document.getElementById(addettoi).value);
                document.getElementById('listaid').value = listaid;
                document.getElementById('listanomi').value = listanomi;
                document.getElementById('listaaddettiippica').value = listaaddettiippica;
                num++;
                document.getElementById('numatt').value = num;
                listaattivitaordinate.push(idattivitaippica);
            } else {
                alert("Attività ippica già ordinata!");
            }
        }
    }
</script>
</html>
<?php
}
}
?>
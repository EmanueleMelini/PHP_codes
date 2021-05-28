<html>
<head>
    <title>Prenota Escursioni</title>
</head>
<body>
<?php
if (!array_key_exists("HTTP_REFERER", $_SERVER)) {
    header("Location: http://localhost/Login/Agriturismo/hub.html");
} else {
require '../agriturismo_connect.php';
session_start();

switch ($_SESSION['Tipo']) {
    case "Cliente":
        $urlportale = "../portale.php";
        break;
    case "Dipendente":
        $urlportale = "../portaledip.php";
        break;
    case "Amministratore":
        $urlportale = "../portaleadmin.php";
        break;
    default :
        $urlportale = "../hub.html";
        break;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $totprezzo = $_POST['totprezzo'];
    $_SESSION['totprezzo'] = $totprezzo;
    $datapren = $_POST['datapren'];
    $listaid = $_POST['listaid'];
    $listanomi = $_POST['listanomi'];
    $listaguide = $_POST['listaguide'];
    $listaidarray = explode(",", $listaid);
    $listanomiarray = explode(",", $listanomi);

    echo("Lista dell'ordine:<br>");

    for ($i = 0; $i < count($listaidarray); $i++) {
        echo("Nome: $listanomiarray[$i]<br>");
    }
    ?>
    Confermare l'ordine?
    <form action="conf_prenotazioni_escursioni.php" method="post">
        <input type="text" value="<?=$datapren?>" name="datapren" hidden>
        <input type="text" value="<?=$listaid?>" name="listaid" hidden>
        <input type="text" value="<?=$listaguide?>" name="listaguide" hidden>
        <input type="text" name="tipo" value="tipici" hidden>
        <input type="submit" value="Conferma">
    </form>
    <?php
} else {
$queryescursioni = "SELECT * FROM Escursioni";
$queryescursioni_result = $conn->query($queryescursioni);
if ($queryescursioni_result->num_rows == 0) {
    echo("Nessuna escursione disponibile");
} else {
?>
<table border="1">
    <?php
    $row_escursioni = $queryescursioni_result->fetch_array();
    $i = 0;
    while ($row_escursioni != null) {
        $prezzoi = "prezzo" . $i;
        $idi = "id" . $i;
        $nomei = "nome" . $i;
        $guidai = "guida" . $i;
        ?>
        <tr>
            <td>Nome:&nbsp;<input type="text" name="Nome" id="<?= $nomei ?>" value="<?= $row_escursioni['Nome'] ?>" readonly></td>
            <td>&nbsp;Meta:&nbsp;<input type="text" name="Meta" value="<?= $row_escursioni['Meta'] ?>" readonly></td>
            <td>&nbsp;Prezzo:&nbsp;<input type="text" name="Prezzo" id="<?= $prezzoi ?>" value="<?= $row_escursioni['Prezzo'] ?>" readonly></td>
            <input type="text" name="id" id="<?= $idi ?>" value="<?= $row_escursioni['idEscursioni'] ?>" hidden>
            <td><select name="guidas" id="<?= $guidai ?>">
                    <option value="-1"> -</option>
                    <?php
                    $queryguide = "SELECT * FROM Dipendenti WHERE idMansione = 3";
                    $queryguide_result = $conn->query($queryguide);
                    $row_guide = $queryguide_result->fetch_array();
                    while ($row_guide != null) {
                        ?>
                        <option value="<?= $row_guide['idDipendenti'] ?>"><?= $row_guide['Nome'] . " " . $row_guide['Cognome'] ?></option>
                        <?php
                        $row_guide = $queryguide_result->fetch_array();
                    }
                    ?>
                </select>
            </td>&nbsp;
            <td><input type="button" value="Aggiungi" onclick="addEscursione(<?= $i ?>)"></td>
        </tr>
        <?php
        $row_escursioni = $queryescursioni_result->fetch_array();
        $i++;
    }
    }
    ?>
</table>
<br>
<form action="" method="post">
    Numero Escursioni:&nbsp;<input type="number" name="numesc" id="numesc" readonly>
    Prezzo:&nbsp;<input type="number" name="totprezzo" id="totprezzo" readonly>
    <input type="text" name="listaid" id="listaid" hidden>
    <input type="text" name="listanomi" id="listanomi" hidden>
    <input type="text" name="listaguide" id="listaguide" hidden>
    <br>Data desiderato&nbsp;<input type="date" name="datapren">
    <br><input type="submit" value="Ordina">
</form>
<br><br>
<form action="<?= $urlportale ?>">
    Torna al portale agriturismo&nbsp;<input type="submit" value="Vai">
</form>
</body>

<script type="text/javascript">
    var listaid = [];
    var listanomi = [];
    var listaguide = [];
    var prezzo = 0;
    var num = 0;
    var listaescursioniordinate = [];
    document.getElementById('totprezzo').value = prezzo;

    function addEscursione(i) {
        var prezzoi = "prezzo" + i;
        var idi = "id" + i;
        var nomei = "nome" + i;
        var guidai = "guida" + i;
        var idescursione = document.getElementById(idi).value;
        if (document.getElementById(guidai).value === "-1") {
            alert("Scegli una guida!");
        } else {
            if (listaescursioniordinate.indexOf(idescursione) === -1) {
                prezzo = prezzo + parseInt(document.getElementById(prezzoi).value);
                document.getElementById('totprezzo').value = prezzo;
                listaid.push(document.getElementById(idi).value);
                listanomi.push(document.getElementById(nomei).value);
                listaguide.push(document.getElementById(guidai).value);
                document.getElementById('listaid').value = listaid;
                document.getElementById('listanomi').value = listanomi;
                document.getElementById('listaguide').value = listaguide;
                num++;
                document.getElementById('numesc').value = num;
                listaescursioniordinate.push(idescursione);
            } else {
                alert("Escursione già ordinata!");
            }
        }
    }
</script>
</html>
<?php
}
}
?>
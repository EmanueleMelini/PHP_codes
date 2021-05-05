<?php
require 'agriturismo_connect.php';
session_start();

$dataoggi = date("Y-m-d");
$oraoggi = date("H:i");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idprencibi = $_POST['idprencibi'];
    $nome = $_POST['nome'];
    $prezzo = $_POST['prezzo'];

    echo("Vuoi cancellare davvero la prenotazione di: $nome?");
    echo("
<form action='elimina_prenotazione_cibo.php' method='post'>
    <input type='submit' value='Elimina'>
    <input type='hidden' name='idprencibi' value='$idprencibi'>
    <input type='hidden' name='prezzo' value='$prezzo'>
</form>");
} else {
    $queryprenotazioni = "select idPrenCibi, idCLiente, DataPren, OraPren, Tavolo, idPiattoTipico, piattitipici.Nome as NomeTipico, piattitipici.Prezzo as PrezzoTipico, idPizza, pizze.Nome as NomePizza, pizze.Prezzo as PrezzoPizza
from (prencibi left outer join piattitipici on prencibi.idPiattoTipico = piattitipici.idPiattiTipici)
left outer join pizze on pizze.idPizze = prencibi.idPizza 
where Datapren >= '$dataoggi' and OraPren >= '$oraoggi' and Eliminato = 0 and idCliente = $_SESSION[idCliente]";
    $queryprenotazioni_result = $conn->query($queryprenotazioni);
    if (!$queryprenotazioni_result) {
        echo("Errore nella query");
    } else {
        $totprezzo = 0;
        echo("Prenotazioni del cliente $_SESSION[Nome] $_SESSION[Cognome]<br>");
        $row_prenotazioni = $queryprenotazioni_result->fetch_array();
        while ($row_prenotazioni != null) {
            if ($row_prenotazioni['idPiattoTipico'] == null) {
                $totprezzo = $totprezzo + $row_prenotazioni['PrezzoPizza'];
                echo("Nome Pizza: $row_prenotazioni[NomePizza].&nbsp;&nbsp;Prezzo: $row_prenotazioni[PrezzoPizza]");
            } else {
                $totprezzo = $totprezzo + $row_prenotazioni['PrezzoTipico'];
                echo("Nome Piatto Tipico: $row_prenotazioni[NomeTipico].&nbsp;&nbsp;Prezzo: $row_prenotazioni[PrezzoTipico]");
            }
            echo(".&nbsp;&nbsp;Data Prenotazione: $row_prenotazioni[DataPren].&nbsp;&nbsp;Ora Prenotazione: $row_prenotazioni[OraPren].&nbsp;&nbsp;Numero tavolo: $row_prenotazioni[Tavolo].<br>");
            echo("<form action='' method='post'>Cancella Prenotazione&nbsp;<input type='submit' value='Cancella'><input type='hidden' name='idprencibi' value='$row_prenotazioni[idPrenCibi]'>");
            if ($row_prenotazioni['idPiattoTipico'] == null) {
                echo("<input type='hidden' name='prezzo' value='$row_prenotazioni[PrezzoPizza]'>");
                echo("<input type='hidden' name='nome' value='$row_prenotazioni[NomePizza]'></form>");
            } else {
                echo("<input type='hidden' name='prezzo' value='$row_prenotazioni[PrezzoTipico]'>");
                echo("<input type='hidden' name='nome' value='$row_prenotazioni[NomeTipico]'></form>");
            }
            $row_prenotazioni = $queryprenotazioni_result->fetch_array();
        }
        echo("Per un totale di $totprezzo euro");
        $_SESSION['totprezzo'] = $totprezzo;
        echo("<br><form action='cancella_tutte_prenotazioni_cibi.php'>Cancella Tutto&nbsp;<input type='submit' value='Cancella'></form>");
    }
}
?>
<html>
<head>
    <title>Visualizza Prenotazioni</title>
</head>
<body>
<form action="portale.php">
    <br>Torna al portale&nbsp;<input type="submit" value="Vai">
</form>
</body>
</html>

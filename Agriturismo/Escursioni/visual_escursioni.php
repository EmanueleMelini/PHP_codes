<html>
<head>
	<title>Escursioni</title>
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
			$utente = "Cliente";
			$urlportale = "../portale.php";
			break;
		case "Dipendente":
			$utente = "Dipendente";
			$urlportale = "../portaledip.php";
			break;
		case "Amministratore":
			$utente = "Amministratore";
			$urlportale = "../portaleadmin.php";
			break;
		default :
			$utente = "Errore";
			$urlportale = "../hub.html";
			break;
	}

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$idescursioni = $_POST['idescursioni'];

		$querycancellaescursione = "DELETE FROM Escursioni WHERE idEscursioni = '$idescursioni'";
		$querycancellaescursione_result = $conn->query($querycancellaescursione);
		if (!$querycancellaescursione_result) {
			echo("Errore nella query");
		} else {
			?>
			Escursione cancellata correttamente <br>
			<form method="get" action="">
				Torna alla visualizzazione delle Escursioni<input type="submit" value="Vai">
			</form>
			<form action="<?= $urlportale ?>">
				Torna al portale<input type="submit" value="Vai">
			</form>
			<?php
		}
	} else {

		$queryescursioni = "SELECT * FROM Escursioni";
		$queryescursioni_result = $conn->query($queryescursioni);
		if ($queryescursioni_result->num_rows == 0) {
			echo("Nessuna pizza nel menu");
		} else {
			?>
			<table border="1">
			<tr>
				<td>Nome Escursione</td>
				<td>Meta</td>
                <td>Prezzo</td>
			</tr><tr>
			<?php
			$row_escursioni = $queryescursioni_result->fetch_array();
			while ($row_escursioni != null) {
				echo("<td>$row_escursioni[Nome]</td><td>$row_escursioni[Meta]</td><td>$row_escursioni[Prezzo]</td>");
				if ($utente == "Amministratore") {
					?>
					<form method="post" action="">
						<td>
							<input type="submit" value="Cancella">
							<input type="text" name="idescursioni" value="<?= $row_escursioni['idEscursioni'] ?>" hidden>
						</td>
					</form>
					<?php
				}
				echo("</tr>");
                $row_escursioni = $queryescursioni_result->fetch_array();
			}
		}
		?>
		</table>
		<br><br>
		<form action="<?= $urlportale ?>">
			Torna al portale agriturismo&nbsp;<input type="submit" value="Vai">
		</form>
		<?php
	}
}
?>
</body>
</html>

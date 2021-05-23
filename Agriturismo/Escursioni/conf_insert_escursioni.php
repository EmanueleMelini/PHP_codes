<html>
<head>
	<title>Inserisci Escursione</title>
</head>
<body>
<?php
if (!array_key_exists("HTTP_REFERER", $_SERVER)) {
	session_destroy();
	header("Location: http://localhost/Login/Agriturismo/hub.html");
} else {
	session_start();
	require '../agriturismo_connect.php';

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

	$nome = $_POST['nome'];
	$meta = $_POST['meta'];

	$queryescursioneins = "INSERT INTO Escursioni(Nome, Meta) VALUES ('$nome', '$meta')";
	$queryescursioneins_result = $conn->query($queryescursioneins);
	if (!$queryescursioneins_result) {
		echo("Errore nella query");
	} else {
		echo("Escursione inserita correttamente");
	}
	?>
	<form action="insert_escursioni.php">
		<br>Torna all'inserimento delle Escursioni&nbsp;<input type="submit" value="Vai">
	</form>
	<form action="<?= $urlportale ?>">
		Torna al portale&nbsp;<input type="submit" value="Vai">
	</form>
	<?php
}
?>
</body>
</html>

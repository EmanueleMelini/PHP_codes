<html>
<head>
	<title>Inserisci Attività Ippiche</title>
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

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$nome = $_POST['nome'];
		$nomecavallo = $_POST['nomecavallo'];
		echo("Vuoi inserire davvero l'attività ippica di nome $nome e cavallo $nomecavallo?");
		?>
		<form action="conf_insert_attivitaippiche.php" method="post">
			<input type="submit" value="Inserisci">
			<input type="text" name="nome" value="<?= $nome ?>" hidden>
			<input type="text" name="nomecavallo" value="<?= $nomecavallo ?>" hidden>
		</form>
		<?php
	} else {
		?>
		Inserisci un'attività ippica:<br>
		<form method="post" action="">
			<br>Nome:&nbsp;<input type="text" name="nome">
			<br>Nome Cavallo:&nbsp;<input type="text" name="nomecavallo">
			<br><input type="submit" value="Inserisci">
		</form>
		<?php
	}
	?>
	<form action="<?= $urlportale ?>">
		Torna al portale&nbsp;<input type="submit" value="Vai">
	</form>
	<?php
}
?>
</body>
</html>

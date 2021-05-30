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
	$querymenu = "SELECT * FROM Pizze";
	$querymenu_result = $conn->query($querymenu);
	if ($querymenu_result->num_rows == 0) {
		echo("Nessuna pizza nel menu");
	} else {
		?>
		<table border="1">
		<tr>
			<td>Nome Pizza</td>
			<td>Descrizione Pizza</td>
			<td>Prezzo Pizza</td>
		</tr>
		<?php
		$row_menu = $querymenu_result->fetch_array();
		while ($row_menu != null) {
			?>
			<tr>
				<td><?= $row_menu['Nome'] ?></td>
				<td><?= $row_menu['Descrizione'] ?></td>
				<td><?= $row_menu['Prezzo'] ?> euro</td>
			</tr>
			<?php
			$row_menu = $querymenu_result->fetch_array();
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
?>
</body>
</html>
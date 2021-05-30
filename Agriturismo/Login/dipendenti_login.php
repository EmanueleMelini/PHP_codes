<?php
require '../agriturismo_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$email = $_POST['Email'];
	$email = $conn->real_escape_string($email);
	$password = $_POST['Password'];
	$password = $conn->real_escape_string($password);

	$querylogin = "SELECT * FROM Dipendenti WHERE '$email' = Email AND '$password' = Password";
	$querylogin_result = $conn->query($querylogin);
	if ($querylogin_result->num_rows == 1) {
		$row_login = $querylogin_result->fetch_array();
		session_start();
		$_SESSION['idDipendente'] = $row_login['idDipendenti'];
		$_SESSION['Email'] = $row_login['Email'];
		$_SESSION['Password'] = $row_login['Password'];
		$_SESSION['Nome'] = $row_login['Nome'];
		$_SESSION['Cognome'] = $row_login['Cognome'];
		$_SESSION['Sesso'] = $row_login['Sesso'];
		$_SESSION['DataN'] = $row_login['DataN'];
		$_SESSION['Telefono'] = $row_login['Telefono'];
		$_SESSION['Indirizzo'] = $row_login['Indirizzo'];
		$_SESSION['Citta'] = $row_login['Citta'];
		$_SESSION['idMansione'] = $row_login['idMansione'];
		$_SESSION['Tipo'] = "Dipendente";
		header("Location: http://localhost/Login/Agriturismo/portaledip.php");
	} else {
		?>
		<form action="" method="get">
			Email o password non corrette
			<input type="submit" value="Indietro">
		</form>
		<?php
	}
} else {
	?>
	<html>
	<head>
		<title>Login Dipendenti</title>
	</head>
	<body>
	<form action="" method="post">
		Login Clienti<br>
		Email&nbsp;<input type="email" name="Email" placeholder="Email"><br>
		Password&nbsp;<input type="password" name="Password" placeholder="Password"><br>
		<input type="submit" value="Login">
	</form>
	<form action="../hub.html">
		<input type="submit" value="Hub">
	</form>
	</body>
	</html>
	<?php
}
?>
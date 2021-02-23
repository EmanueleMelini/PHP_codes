<?php
	$conn = new mysqli("localhost", "Lele", "Lele20010205", "community");

	if ($conn->connect_error)
		die ("Errore di connessione ($conn->connect_errno), $conn->connect_error");
	#else
		#echo ("Connesso $conn->host_info  \n");

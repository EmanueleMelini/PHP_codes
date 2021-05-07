<?php
$conn = new mysqli("192.168.100.7", "e.melini", "Lele@2001", "agriturismo");

if ($conn->connect_error)
    die ("Errore di connessione ($conn->connect_errno), $conn->connect_error");
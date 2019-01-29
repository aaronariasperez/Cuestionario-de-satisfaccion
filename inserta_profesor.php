<?php
	$server = "localhost";
	$user = "root";
	$pass = "";
	$db = "encuestas_bd";

	// Create connection
	$conn = new mysqli($server, $user, $pass, $db);

	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}

	$nombre = $_POST["nombre"];

	$conn->query("INSERT INTO Profesores (nombre) VALUES ('$nombre')");

	header("Location: panel_admin.php");

	$conn->close();
?>
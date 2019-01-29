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

	$enun = $_POST["enun"].":";
	$pos_sols = $_POST["pos_sols"];
	$tipo = $_POST["tipo"];

	$conn->query("INSERT INTO Preguntas (enunciado, posible_sols, tipo) VALUES ('$enun','$pos_sols','$tipo')");

	header("Location: panel_admin.php");

	$conn->close();
?>
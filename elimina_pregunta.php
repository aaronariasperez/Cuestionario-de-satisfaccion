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

	if(!empty($_POST["borrar"])){
				
		foreach($_POST["borrar"] as $box) {
			$conn->query("DELETE FROM Respuestas WHERE id_preg=$box")
			or die("Error en la eliminacion de respuestas");	

			$conn->query("DELETE FROM Preguntas WHERE id=$box")
			or die("Error en la eliminacion de preguntas");	

		}
	}

	header("Location: panel_admin.php");

	$conn->close();
?>
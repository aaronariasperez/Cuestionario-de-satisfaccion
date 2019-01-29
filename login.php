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

	$user = $_POST["user"];
	$pass = $_POST["pass"];

	$res = $conn->query("SELECT * FROM Administradores WHERE usuario='$user' AND password='$pass'") or die($conn->error);
	$res = $res->fetch_assoc();

	session_start();

	if(empty($res)){
		echo "<h2>Usuario y/o contraseña incorrecta/s.</h2>";
		echo "<a href=\"index.php\">Volver a la encuesta.</a>";
	}else{
		if(!isset($_SESSION['usuario'])){
			$_SESSION['usuario'] = $user;
			header("Location: panel_admin.php");
		}
	}


	$conn->close();
?>
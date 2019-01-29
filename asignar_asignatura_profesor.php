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

	$asig = $_POST["asig"];
	$prof = $_POST["prof"];

	$res1= $conn->query("SELECT id,nombre FROM Asignaturas WHERE nombre='$asig'");
	$res2 = $conn->query("SELECT id,nombre FROM Profesores WHERE nombre='$prof'");
	$id_asig = $res1->fetch_assoc();
	$id_prof = $res2->fetch_assoc();

	if(!empty($id_asig)){
		if(!empty($id_prof)){

			$id_asig = $id_asig["id"];
			$id_prof = $id_prof["id"];

			$verificar_asig_prof = $conn->query("SELECT * FROM Asignatura_Profesor WHERE id_asig=$id_asig AND id_prof=$id_prof");
			$verificar_asig_prof = $verificar_asig_prof->fetch_assoc();

			if(empty($verificar_asig_prof)){
				$conn->query("INSERT INTO Asignatura_Profesor (id_asig,id_prof) VALUES ($id_asig, $id_prof)");
				header("Location: panel_admin.php");

			}else{
				echo "El profesor $prof ya estaba asignado a $asig.<br>";
				echo "<br><a href=\"panel_admin.php\">Volver.</a>";
			}
		}else{
			echo "El profesor $prof no existe.<br>";
			echo "<br><a href=\"panel_admin.php\">Volver.</a>";
		}
	}else{
		echo "La asignatura $asig no existe.<br>";
		echo "<br><a href=\"panel_admin.php\">Volver.</a>";
	}
	
	$conn->close();
?>
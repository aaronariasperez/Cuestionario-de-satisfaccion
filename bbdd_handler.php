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
	
	if(!empty($asig) && !empty($prof))
	{

		$res1= $conn->query("SELECT id,nombre FROM Asignaturas WHERE nombre='$asig'");
		$res2 = $conn->query("SELECT id,nombre FROM Profesores WHERE nombre='$prof'");
		$id_asig = $res1->fetch_assoc();
		$id_prof = $res2->fetch_assoc();
		$name_asig = $id_asig["nombre"];
		$name_prof = $id_prof["nombre"];
		$id_asig = $id_asig["id"];
		$id_prof = $id_prof["id"];

		$verificar_asig_prof = $conn->query("SELECT * FROM Asignatura_Profesor WHERE id_asig=$id_asig AND id_prof=$id_prof");
		$verificar_asig_prof = $verificar_asig_prof->fetch_assoc();

		if(empty($verificar_asig_prof)){ //aqui se comprueba si el profesor imparte la asignatura
			die("<h2>El profesor $name_prof no imparte la asignatura $name_asig.</h2>");
			
		}else{

			$conn->query("INSERT INTO Encuestas (id_asig, id_prof) VALUES ($id_asig, $id_prof)");
			$last_id = $conn->insert_id;

			unset($_POST["asig"]);
			unset($_POST["prof"]);

			foreach($_POST as $clave => $valor){
				$conn->query("INSERT INTO Respuestas (id_preg, respuesta, id_encuesta) VALUES ($clave, '$valor', $last_id)");
			}

			echo "<h1>Gracias por rellenar la encuesta.</h1>";
		}
	}
	else
		echo "<h1>Encuesta no enviada por falta de datos.</h1>";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Estadística</title>
</head>
<link rel="stylesheet" type="text/css" href="style/style.css" />

<body>

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

		session_start();
		if(isset($_SESSION['usuario'])) session_destroy(); //para reiniciar la session de acceso al panel de administracion
	?>

	<br>
		<div align="center"><h1>Estadísticas</h1></div>
	<br>


	<div id="simpletext" align="center">
		Filtre por asignatura, profesor y perfil para ver los resultados:
		<br><br>

	<form action="bbdd_handler2.php" method="post">

	Asignatura: <input name="asig" list="asignaturas_lista">

	<datalist id="asignaturas_lista">
  		<?php
  			$result = $conn->query("SELECT * FROM Asignaturas");
  			while($row = $result->fetch_assoc()){
  				$name = $row["nombre"];
  				echo "<option value=\"$name\">";
  			}
  		?>
	</datalist>
	</div>
	
	<br>

	<div id="simpletext" align="center">
	Profesor: <input name="prof" list="profesores_lista">

	<datalist id="profesores_lista">
  		<?php
  			$result = $conn->query("SELECT * FROM Profesores");
  			while($row = $result->fetch_assoc()){
  				$name = $row["nombre"];
  				echo "<option value=\"$name\">";
  			}
  		?>
	</datalist>
	</div>

	<br>
	<br>

	<table>

		<?php

			$result = $conn->query("SELECT id,enunciado, posible_sols FROM Preguntas WHERE tipo='perfil'");
			while($row = $result->fetch_assoc()){
				echo "<tr>";
				$enun = $row["enunciado"];
				echo "<td>$enun</td>";
				$sols = explode("&",$row["posible_sols"]);

				$id = $row["id"];
				foreach($sols as $sol){
					echo "<td ><input type=\"radio\" name=\"$id\" value=\"$sol\">$sol</td>";
				}
				echo "</tr>";
			}
		?>
	</table>

	<br><div align="center">
	<input type="submit" value="Enviar"></div>
	</form>

	<?php
		$conn->close();
	?>
</body>
</html>
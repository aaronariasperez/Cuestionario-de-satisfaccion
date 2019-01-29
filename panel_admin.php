<!DOCTYPE html>
<html>
<head>
	<title>Panel de administracion</title>
</head>
<link rel="stylesheet" type="text/css" href="style/style.css" />
<body>
	<?php

		session_start();

		if(isset($_SESSION['usuario'])){
			
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

			?>

			<div align="center"><h1>Panel de administracion.</h1><br>
			<div id="simpletext"><h3>Preguntas.</h3>
			<small>(* Las posibles soluciones se escribiran con el formato: a&b&c..)</small>

			<form action="inserta_pregunta.php" method="post">
			Enunciado: <input type="text" name="enun">
			*Posibles Soluciones: <input type="text" name="pos_sols">
			Tipo: Perfil <input type="radio" name="tipo" value="perfil" checked> Otro <input type="radio" name="tipo" value="otro">
			<br>
			<input type="submit" value="Añadir">
			</form>
			</div>
	<?php
			$result = $conn->query("SELECT id,enunciado,posible_sols FROM Preguntas");
			echo "<br><form action=\"elimina_pregunta.php\" method=\"post\">";
			echo "<table border>";
			echo "<tr>";
			echo "<th>Enunciado</th>";
			echo "<th>Respuestas posibles</th>";
			echo "<th>Seleccionar</th>";
			echo "</tr>";
			while($row = $result->fetch_assoc()){
				echo "<tr>";
				$enun = $row["enunciado"];
				echo "<td>$enun</td>";
				$pos_sols = $row["posible_sols"];
				echo "<td>$pos_sols</td>";

				$id = $row["id"];
				echo "<td><input type=\"checkbox\" name=\"borrar[]\" value=\"$id\"></td>";

				echo "</tr>";
			}
			echo "</table>";
			echo "<br><input type=\"submit\" value=\"Eliminar seleccionados\">";
			echo "</form>";
	?> </div>
			
			<div align="center"><div id="simpletext">
			<h3>Asignaturas.</h3>

			<form action="inserta_asignatura.php" method="post">
			Nombre: <input type="text" name="nombre">
		
			<br><br>
			<input type="submit" value="Añadir">
			</form>

	<?php
			$result = $conn->query("SELECT id,nombre FROM Asignaturas");
			echo "<br><form action=\"elimina_asignatura.php\" method=\"post\">";
			echo "<table border>";
			echo "<tr>";
			echo "<th>Nombre</th>";
			echo "<th>Seleccionar</th>";
			echo "</tr>";
			while($row = $result->fetch_assoc()){
				echo "<tr>";
				$nombre = $row["nombre"];
				echo "<td>$nombre</td>";

				$id = $row["id"];
				echo "<td><input type=\"checkbox\" name=\"borrar[]\" value=\"$id\"></td>";

				echo "</tr>";
			}
			echo "</table>";
			echo "<br><input type=\"submit\" value=\"Eliminar seleccionados\">";
			echo "</form>";		

	?>
	</div></div>
			<div align="center"><div id="simpletext">
			<h3>Profesores.</h3>

			<form action="inserta_profesor.php" method="post">
			Nombre: <input type="text" name="nombre">
			<br>
			<br>
			<input type="submit" value="Añadir">
			</form>

	<?php
			$result = $conn->query("SELECT id,nombre FROM Profesores");
			echo "<br><form action=\"elimina_profesor.php\" method=\"post\">";
			echo "<table border>";
			echo "<tr>";
			echo "<th>Nombre</th>";
			echo "<th>Seleccionar</th>";
			echo "</tr>";
			while($row = $result->fetch_assoc()){
				echo "<tr>";
				$nombre = $row["nombre"];
				echo "<td>$nombre</td>";

				$id = $row["id"];
				echo "<td><input type=\"checkbox\" name=\"borrar[]\" value=\"$id\"></td>";

				echo "</tr>";
			}
			echo "</table>";
			echo "<br><input type=\"submit\" value=\"Eliminar seleccionados\">";
			echo "</form>";	

	?> </div></div>
			<div align="center"><div id="simpletext">
			<h3>Asignacion de profesor-asignatura.</h3>

			<form action="asignar_asignatura_profesor.php" method="post">
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
		
			<input type="submit" value="Asignar">
			</form>
			<br>

			<form action="eliminar_asignatura_profesor.php" method="post">
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
		
			<input type="submit" value="Eliminar asignacion">
			</form>

	<?php
			$result = $conn->query("SELECT id_asig,id_prof FROM Asignatura_Profesor");
			echo "<br>";
			echo "<table border>";
			echo "<tr>";
			echo "<th>Asignatura</th>";
			echo "<th>Impartida por:</th>";
			echo "</tr>";
			while($row = $result->fetch_assoc()){
				echo "<tr>";

				$id_asig = $row["id_asig"];
				$id_prof = $row["id_prof"];
				
				$nombre_asig = $conn->query("SELECT nombre FROM Asignaturas WHERE id=$id_asig");
				$nombre_asig = $nombre_asig->fetch_assoc();
				$nombre_asig = $nombre_asig["nombre"];

				$nombre_prof = $conn->query("SELECT nombre FROM Profesores WHERE id=$id_prof");
				$nombre_prof = $nombre_prof->fetch_assoc();
				$nombre_prof = $nombre_prof["nombre"];

				echo "<td>$nombre_asig</td>";
				echo "<td>$nombre_prof</td>";

				echo "</tr>";
			}
			echo "</table>";
			echo "<br>";

			//*******************Fin tablas*******************
			echo "<br><a href=\"index.php\">Volver a la encuesta.</a><br>";
			echo "<a href=\"estadisticas.php\">Estadisticas.</a>";

			$conn->close();

		}else{ //redirecciona al index si no se ha logueado (no se tiene acceso al panel si no se ha logeado)
			header("Location: index.php");
		}
	?> </div></div>
</body>
</html>

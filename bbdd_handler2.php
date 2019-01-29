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

		$asig = $_POST["asig"];
		$prof = $_POST["prof"];

		if(!empty($asig) && !empty($prof))
		{
			?>

			<br>
				<div align="center"><h1>Estadísticas</h1></div>
			<br>

			<?php

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
					echo "<div id=\"simpletext\" align=\"center\">";
					die("<h2>El profesor $name_prof no imparte la asignatura $name_asig.</h2>");
					echo "</div>";
					
				}
				else
				{
					unset($_POST["asig"]);
					unset($_POST["prof"]);
					echo "<div id=\"simpletext\" align=\"center\">Porcentaje de alumnos que valoraron la pregunta:</div>";
					if(!empty($_POST))
					{
						$principio = "SELECT * FROM Respuestas WHERE id_preg IN (SELECT id FROM Preguntas WHERE tipo='otro') AND id_encuesta IN (SELECT id FROM Encuestas AS enc INNER JOIN ( ";
					
						$consulta = "";
						foreach($_POST as $clave => $valor){
							$consulta = $consulta."SELECT id_encuesta FROM Respuestas WHERE id_preg=$clave AND respuesta='$valor' AND id_encuesta IN (";
						}
						$consulta = substr($consulta,0,-5);
						$num_parentesis = substr_count($consulta,"(");
						for($i = 0; $i < $num_parentesis; $i++){
							$consulta = $consulta.")";
						}
						$consulta = $consulta.") resp ON enc.id = resp.id_encuesta WHERE enc.id_asig = $id_asig AND enc.id_prof= $id_prof)";
						$consulta = $principio.$consulta;

						$result_respuestas = $conn->query($consulta);

						$result_preguntas = $conn->query("SELECT id,enunciado, posible_sols FROM Preguntas WHERE tipo='otro'");

						while($row1 = $result_preguntas->fetch_assoc())
						{
							$cont[$row1["id"]] = 0;

							for($i=0; $i<5; $i++)
								$porcentajes[$row1["id"]][$i] = 0;	
						}

						while($row2 = $result_respuestas->fetch_assoc())
						{
							switch ($row2["respuesta"])
							{
    							case 1:
        							$porcentajes[$row2["id_preg"]][0] = $porcentajes[$row2["id_preg"]][0] + 1;
        							break;
    							case 2:
        							$porcentajes[$row2["id_preg"]][1] = $porcentajes[$row2["id_preg"]][1] + 1;
        							break;
    							case 3:
        							$porcentajes[$row2["id_preg"]][2] = $porcentajes[$row2["id_preg"]][2] + 1;
        							break;
        						case 4:
        							$porcentajes[$row2["id_preg"]][3] = $porcentajes[$row2["id_preg"]][3] + 1;
        							break;
        						case 5:
        							$porcentajes[$row2["id_preg"]][4] = $porcentajes[$row2["id_preg"]][4] + 1;
        							break;
							}
							$cont[$row2["id_preg"]] = $cont[$row2["id_preg"]] + 1;
						}

						echo "<div id=\"simpletext\" align=\"center\">";
						echo "<h2>Profesor: $name_prof</h2>";
						echo "<h2>Asignatura: $name_asig</h2>";

						
						$result_preguntas = $conn->query("SELECT id,enunciado, posible_sols FROM Preguntas WHERE tipo='otro'");
						echo "<table>";
						while($row3 = $result_preguntas->fetch_assoc()){
							echo "<tr>";
							$enun = $row3["enunciado"];
							echo "<td>$enun</td>";
							$sols = explode("&",$row3["posible_sols"]);

							$id = $row3["id"];
							foreach($sols as $sol){
								if($cont[$row3["id"]]==0){
									$porcent=0;
								}else{
									$porcent = $porcentajes[$id][$sol-1]/$cont[$row3["id"]] * 100;
								}
								echo "<td ><name=\"$id\" value=\"$sol\">$sol($porcent %)</td>";
							}	
						echo "</tr>";
						}
						echo "</table>";
						
						//Sacar las encuestas a mirar
						/*  SELECT * FROM respuestas
						WHERE id_encuesta IN 
						(SELECT id
						FROM encuestas AS enc 
						INNER JOIN 
						(
							SELECT id_encuesta 
							FROM respuestas
							WHERE id_preg=1 AND respuesta='mujer' AND id_encuesta IN (
								SELECT id_encuesta from respuestas WHERE id_preg=3 AND respuesta=2
							)
						) resp
						ON enc.id = resp.id_encuesta
						WHERE enc.id_asig=1 AND enc.id_prof=1)*/
					}
					else
					{
						$result_respuestas = $conn->query("SELECT * FROM Respuestas WHERE id_encuesta IN (SELECT id FROM Encuestas WHERE id_asig=$id_asig AND id_prof=$id_prof) AND id_preg IN (SELECT id FROM Preguntas WHERE tipo='otro')");

						$result_preguntas = $conn->query("SELECT id,enunciado, posible_sols FROM Preguntas WHERE tipo='otro'");

						while($row1 = $result_preguntas->fetch_assoc())
						{
							$cont[$row1["id"]] = 0;

							for($i=0; $i<5; $i++)
								$porcentajes[$row1["id"]][$i] = 0;	
						}

						while($row2 = $result_respuestas->fetch_assoc())
						{
							switch ($row2["respuesta"])
							{
    							case 1:
        							$porcentajes[$row2["id_preg"]][0] = $porcentajes[$row2["id_preg"]][0] + 1;
        							break;
    							case 2:
        							$porcentajes[$row2["id_preg"]][1] = $porcentajes[$row2["id_preg"]][1] + 1;
        							break;
    							case 3:
        							$porcentajes[$row2["id_preg"]][2] = $porcentajes[$row2["id_preg"]][2] + 1;
        							break;
        						case 4:
        							$porcentajes[$row2["id_preg"]][3] = $porcentajes[$row2["id_preg"]][3] + 1;
        							break;
        						case 5:
        							$porcentajes[$row2["id_preg"]][4] = $porcentajes[$row2["id_preg"]][4] + 1;
        							break;
							}
							$cont[$row2["id_preg"]] = $cont[$row2["id_preg"]] + 1;
						}

						echo "<div id=\"simpletext\" align=\"center\">";
						echo "<h2>Profesor: $name_prof</h2>";
						echo "<h2>Asignatura: $name_asig</h2>";

						
						$result_preguntas = $conn->query("SELECT id,enunciado, posible_sols FROM Preguntas WHERE tipo='otro'");
						echo "<table>";
						while($row3 = $result_preguntas->fetch_assoc()){
							echo "<tr>";
							$enun = $row3["enunciado"];
							echo "<td>$enun</td>";
							$sols = explode("&",$row3["posible_sols"]);

							$id = $row3["id"];
							foreach($sols as $sol){
								if($cont[$row3["id"]] == 0){
									$porcent = 0;
								}else{
									$porcent = $porcentajes[$id][$sol-1]/$cont[$row3["id"]] * 100;
								}
								echo "<td ><name=\"$id\" value=\"$sol\">$sol($porcent %)</td>";
							}	
						echo "</tr>";
						}
						echo "</table>";
					}
					echo "</div>";
				}
		}

		$conn->close();
	?>
</body>
</html>

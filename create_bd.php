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

	//Restart the BD
	$query = "DROP TABLE Administradores;";
	$conn->query($query) or trigger_error(mysqli_error($conn));

	$query = "DROP TABLE Respuestas;";
	$conn->query($query) or trigger_error(mysqli_error($conn));

	$query = "DROP TABLE Encuestas;";
	$conn->query($query) or trigger_error(mysqli_error($conn));

	$query = "DROP TABLE Preguntas;";
	$conn->query($query) or trigger_error(mysqli_error($conn));

	$query = "DROP TABLE Asignatura_Profesor;";
	$conn->query($query) or trigger_error(mysqli_error($conn));

	$query = "DROP TABLE Asignaturas;";
	$conn->query($query) or trigger_error(mysqli_error($conn));

	$query = "DROP TABLE Profesores;";
	$conn->query($query) or trigger_error(mysqli_error($conn));


	$query = "CREATE TABLE Asignaturas(
		id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
		nombre text NOT NULL
		)";
	$conn->query($query) or die ("Error creando tabla Asignaturas");

	$query="CREATE TABLE Profesores(
		id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
		nombre text NOT NULL
     	)";
	$conn->query($query) or die ("Error creando tabla Profesores");

	$query="CREATE TABLE Asignatura_Profesor(
		id_asig int NOT NULL ,
		id_prof int NOT NULL ,
  		FOREIGN KEY (id_prof) REFERENCES Profesores(id),
  		FOREIGN KEY (id_asig) REFERENCES Asignaturas(id)
     	)";
	$conn->query($query) or die ("Error creando tabla Asignatura_Profesor");

	$query="CREATE TABLE Preguntas(
		id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
		enunciado text NOT NULL,
  		posible_sols text NOT NULL,
  		tipo text NOT NULL
     	)";
	$conn->query($query) or die ("Error creando tabla Preguntas");
  	
  	$query="CREATE TABLE Encuestas(
		id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  		id_asig int NOT NULL,
  		id_prof int NOT NULL,
  		FOREIGN KEY (id_asig) REFERENCES Asignaturas(id),
  		FOREIGN KEY (id_prof) REFERENCES Profesores(id)
     	)";
	$conn->query($query) or die ("Error creando tabla Encuestas");
  
  	$query="CREATE TABLE Respuestas(
		id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  		id_preg int NOT NULL,
  		respuesta text NOT NULL,
  		id_encuesta int NOT NULL,
  		FOREIGN KEY (id_preg) REFERENCES Preguntas(id),
  		FOREIGN KEY (id_encuesta) REFERENCES Encuestas(id)
     	)";
	$conn->query($query) or die ("Error creando tabla Respuestas");

	$query="CREATE TABLE Administradores(
		id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  		usuario text NOT NULL,
  		password text NOT NULL
     	)";
	$conn->query($query) or die ("Error creando tabla Administradores");

	//----Inserciones Asignaturas----

	$query = "INSERT INTO Asignaturas (nombre) VALUES ('pctr')";
	$conn->query($query) or trigger_error(mysqli_error($conn));

	$query = "INSERT INTO Asignaturas (nombre) VALUES ('pw')";
	$conn->query($query) or trigger_error(mysqli_error($conn));

	$query = "INSERT INTO Asignaturas (nombre) VALUES ('ednl')";
	$conn->query($query) or trigger_error(mysqli_error($conn));
	
	//----Inserciones Profesores----

	$query = "INSERT INTO Profesores (nombre) VALUES ('juan')";
	$conn->query($query) or trigger_error(mysqli_error($conn));

	$query = "INSERT INTO Profesores (nombre) VALUES ('julian')";
	$conn->query($query) or trigger_error(mysqli_error($conn));

	$query = "INSERT INTO Profesores (nombre) VALUES ('jose')";
	$conn->query($query) or trigger_error(mysqli_error($conn));

	//----Inserciones Asignatura_Profesor----

	$query = "INSERT INTO Asignatura_Profesor (id_asig, id_prof) VALUES (1,1)";
	$conn->query($query) or trigger_error(mysqli_error($conn));

	$query = "INSERT INTO Asignatura_Profesor (id_asig, id_prof) VALUES (2,2)";
	$conn->query($query) or trigger_error(mysqli_error($conn));

	$query = "INSERT INTO Asignatura_Profesor (id_asig, id_prof) VALUES (3,3)";
	$conn->query($query) or trigger_error(mysqli_error($conn));

	//----Inserciones Preguntas----

	$query = "INSERT INTO Preguntas (enunciado, posible_sols, tipo) VALUES ('Sexo:', 'hombre&mujer', 'perfil')";
	$conn->query($query) or trigger_error(mysqli_error($conn));

	$query = "INSERT INTO Preguntas (enunciado, posible_sols, tipo) VALUES ('Edad:', '<18&<20&>25&>45', 'perfil')";
	$conn->query($query) or trigger_error(mysqli_error($conn));

	$query = "INSERT INTO Preguntas (enunciado, posible_sols, tipo) VALUES ('Curso mas alto:', '1&2&3&4&5', 'perfil')";
	$conn->query($query) or trigger_error(mysqli_error($conn));

	$query = "INSERT INTO Preguntas (enunciado, posible_sols, tipo) VALUES ('Valoracion general:', '1&2&3&4&5', 'otro')";
	$conn->query($query) or trigger_error(mysqli_error($conn));

	$query = "INSERT INTO Preguntas (enunciado, posible_sols, tipo) VALUES ('Asiste a clase regularmente:', '1&2&3&4&5', 'otro')";
	$conn->query($query) or trigger_error(mysqli_error($conn));

	$query = "INSERT INTO Preguntas (enunciado, posible_sols, tipo) VALUES ('Buena bibliografia:', '1&2&3&4&5', 'otro')";
	$conn->query($query) or trigger_error(mysqli_error($conn));

	//----Inserciones Administradores----

	$query = "INSERT INTO Administradores (usuario, password) VALUES ('admin','admin')";
	$conn->query($query) or trigger_error(mysqli_error($conn));

	//----Inserciones Encuestas----

	$query = "INSERT INTO Encuestas (id_asig, id_prof) VALUES (1,1)";
	$conn->query($query) or trigger_error(mysqli_error($conn));

	$query = "INSERT INTO Encuestas (id_asig, id_prof) VALUES (2,2)";
	$conn->query($query) or trigger_error(mysqli_error($conn));

	$query = "INSERT INTO Encuestas (id_asig, id_prof) VALUES (3,3)";
	$conn->query($query) or trigger_error(mysqli_error($conn));

	//----Inserciones Respuestas----

	$query = "INSERT INTO Respuestas (id_preg, respuesta, id_encuesta) VALUES (1, 'hombre', 1)";
	$conn->query($query) or trigger_error(mysqli_error($conn));

	$query = "INSERT INTO Respuestas (id_preg, respuesta, id_encuesta) VALUES (2, '<18', 1)";
	$conn->query($query) or trigger_error(mysqli_error($conn));

	$query = "INSERT INTO Respuestas (id_preg, respuesta, id_encuesta) VALUES (3, '4', 1)";
	$conn->query($query) or trigger_error(mysqli_error($conn));

	$query = "INSERT INTO Respuestas (id_preg, respuesta, id_encuesta) VALUES (4, '3', 1)";
	$conn->query($query) or trigger_error(mysqli_error($conn));

	$query = "INSERT INTO Respuestas (id_preg, respuesta, id_encuesta) VALUES (5, '5', 1)";
	$conn->query($query) or trigger_error(mysqli_error($conn));

	$query = "INSERT INTO Respuestas (id_preg, respuesta, id_encuesta) VALUES (6, '2', 1)";
	$conn->query($query) or trigger_error(mysqli_error($conn));

	$conn->close();
?>

<h2>Creacion de BD terminada. </h2>
<?php
	//PREGUNTAMOS SI LA VARIABLE $_GET ESTÁ INICIALIZADA
	if(isset($_GET["btnGuardar"]))
	{
?>

	<!DOCTYPE html>
	<html lang="es">
		<head>
			<title>Recepción de datos</title>
			<meta charset="UTF-8">
		</head>
		<body>
			<h1>Recibiendo los datos del formulario</h1>
<?php
			//RECOGE LOS DATOS EN EL CAMPO "Nombre" DEL DOCUMENTO.
				echo "<p><strong>Nombre: </strong>".$_GET["nombre"]."</p>";
				echo "<p><strong>Apellidos: </strong>".$_GET["apellidos"]."</p>";
				echo "<p><strong>Contraseña: </strong>".$_GET["contrasena"]."</p>";
				echo "<p><strong>DNI: </strong>".$_GET["dni"]."</p>";
				if(isset($_GET["sexo"]))
				{
				//SI HAY SÓLO UNA SENTENCIA EN EL IF, PODEMOS AHORRARNOS LAS LLAVES.
				echo "<p><strong>Sexo: </strong>".$_GET["sexo"]."</p>";
				}
				echo "<p><strong>Nacido en: </strong>".$_GET["nacimiento"]."</p>";
				echo "<p><strong>Comentarios: </strong".$_GET["comentarios"]."</p>";
				if(isset($_GET["suscripcion"]))
				{
				echo "<p><strong>Suscrito: </strong>Si</p>";
				}else{
				echo "<p><strong>Suscrito: </strong>No</p>";
				}
?>

		</body>
	</html>
<?php
	}
	else
	{
	//SI NO EXISTE DATOS ENVIADOS MEDIANTE SUBMIT, NOS DEVUELVE A LA PAGINA index.php QUE ES LA PAGINA INICIAL.
		header("Location: index.php");
	}
?>

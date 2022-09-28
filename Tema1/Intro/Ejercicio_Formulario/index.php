<?php
	if(isset($_POST["btnEnviar"])){
		//COMPROBAMOS ERRORES
		$error_nombre = $_POST["nombre"]==""; //CUANDO EL $_POST DE NOMBRE ESTÉ VACIO.
		$error_sexo = !isset($_POST["sexo"]); //CUANDO NO SE HAYA MARCADO NINGUN SEXO.

		
		$errores_formulario = $error_nombre || $error_sexo;
	}
	if(isset($_POST["btnEnviar"]) && !$errores_formulario){
		//SI NO HAY ERRORES, MOSTRAMOS LAS RESPUESTAS
		
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<title>Respuestas</title>
		<meta charset="UTF-8">
	</head>
	<body>
		<h1>Datos recibidos</h1>
		<p><strong>El nombre recibido es: </strong> <?php echo $_POST["nombre"];?></p>
		<p><strong>Ha nacido en: </strong><?php echo $nacido[$_POST["nacido"]];?></p>
		<p><strong>El sexo es: </strong><?php echo $_POST["sexo"];?></p>
	
		<?php
			if(isset($_POST["aficiones"])){
				$n_aficiones = count($_POST["aficiones"]);
				if($n_aficiones > 1){
					echo "<p><strong>Las aficiones seleccionadas han sido:</strong></p>";
				} else {
					echo "<p><strong>Las afición seleccionada ha sido:</strong></p>";
				}
			} else {
				echo "<p><strong>No has seleccionado ninguna afición.</strong></p>"
			}
		?>
	</body>
</html>
<!DOCTYPE html>
	<head>
		<title>Mi primera página PHP</title>
		<meta charset="UTF-8">
	</head>
	<body>
	<h1>Esta es mi super página</h1>
		<form method="post" action="index.php" ectype="multipart/form-data">
			<p>
				<label for="nombre">Nombre: </label>
				<input type="text" name="nombre" id="nombre" value="<?php if(isset($_POST["nombre"])) echo $_POST["nombre"];?>"/>
				<?php
					if (isset($_POST["nombre"]) && $error_nombre)
					echo "<span class='error'>*** CAMPO OBLIGATORIO *** </span>";
				?>
			</p>
			<p>
				<label for="nacido">Nacido en: </label>
				<select id="nacido">
					<option value="0">Málaga</option>
					<option value="1">Cádiz</option>
					<option value="2">Granada</option>
				</select>
			</p>
			<p>
				<label id="sexo">Sexo: </label>
				<label for="hombre">Hombre</label><input type="radio" id="hombre" name="sexo" value="hombre" <?php if(isset($%_POST["sexo"]) && $_POST["sexo"]=="Hombre"?>/>
				<label for="mujer">Mujer</label><input type="radio" id="mujer" name="sexo" value="mujer"/>
				<?php
					if(isset($_POST["btnEnviar"]) && $error_sexo)
					echo "<span class='error'>*** DEBES MARCAR UNA OPCIÓN ***</span>";
				?>
			</p>
			<p>
				<label>Aficiones: </label>
				<label for="deportes">Deportes</label><input type="checkbox" id="deportes" name="aficiones[]" value="deportes"/>
				<label for="lectura">Lectura</label><input type="checkbox" id="lectura" name="aficiones[]" value="lectura"/>
				<label for="otros">Otros</label><input type="checkbox" id="otros" name="aficiones[]" value="otros"/>
			</p>
			<p>
				<label for="comentarios">Comentarios: </label><textarea id="comentarios" cols="30" rows="5"></textarea>
			</p>
			
			<button type="submit" name="btnEnviar">Enviar</button>
		</form>
	</body>
</html>
<?php

?>

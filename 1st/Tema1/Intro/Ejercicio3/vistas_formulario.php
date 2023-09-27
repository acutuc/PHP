<!DOCTYPE html>
<html lang="es">
	<head>
		<title></title>
		<meta charset="UTF-8"/>
	</head>
	<body>
		<h1>Rellena tu CV</h1>
		<!--NO OLVIDAR DE PONER LOS ATRIBUTOS "name" EN LOS INPUT-->
		<form method="post" action="index.php" enctype="multipart/form-data">
			<label for="nombre">Nombre</label>
			<br/>
			<input type="text" id="nombre" name="nombre" value="<?php if(isset($_POST["nombre"])) echo $_POST["nombre"]; ?>"/>
			<?php
				if(isset($_POST["nombre"]) && $error_nombre)
					echo "<span class='error'>  ***Campo vacio***</span>";
			?>
			<br/>
			<label for="apellidos">Apellidos</label>
			<br/>
			<input type="text" id="apellidos" size="50" name="apellidos" value="<?php if(isset($_POST["apellidos"])) echo $_POST["apellidos"]; ?>"/>
			<?php
				if(isset($_POST["apellidos"]) && $error_apellidos)
					echo "<span class='error'>  ***Campo vacio***</span>";
			?>
			<br/>
			<label for="contrasena">Contraseña</label>
			<br/>
			<input type="password" id="contrasena" name="contrasena"/>
			<?php
				if(isset($_POST["contrasena"]) && $error_contrasena)
					echo "<span class='error'>  ***Campo vacio***</span>";
			?>
			<br/>
			<label for="dni">DNI</label>
			<br/>
			<input type="text" id="dni" size="10" maxlength="9" name="dni" value="<?php if(isset($_POST["dni"])) echo $_POST["dni"]; ?>"/>
			<?php
				if(isset($_POST["dni"]) && $error_dni)
					echo "<span class='error'>  ***Campo vacio***</span>";
			?>
			<br/>
			<label id="sexo">Sexo</label>
			<?php
				if(isset($_POST["btnGuardar"]) && $error_sexo)
					echo "<span class='error'>  ***Debe marcar una opción.***</span>";
			?>
			<br/>
			<!--PONER "value" A LOS INPUT DE TIPO RADIO-->
			<input type="radio" name="sexo" id="hombre" value="hombre" <?php if(isset($_POST["sexo"]) && $_POST["sexo"] == "hombre") 
				echo "checked>"?>><label for="hombre">Hombre</label>
			<br/>
			<input type="radio" name="sexo" id="mujer" value="mujer"/><label for="mujer" <?php if(isset($_POST["sexo"]) && $_POST["sexo"] == "mujer") 
				echo "checked>"?>><label for="mujer">Mujer</label>
			<br/>
			<!--EL ATRIBUTO "accept" SIRVE PARA FILTRAR EL TIPO DE ARCHIVO QUE PUEDE ADJUNTAR EL USUARIO.-->
			<a for="foto">Incluir mi foto: </a><input type="file" id="foto" name="foto" accept="image/*"/>
			<br/>
			<br/>
			<label for="nacimiento">Nacido en: </label>
			<select id="nacimiento" name="nacimiento">
				<option value="Málaga">Málaga</option>
				<option value="Granada" <?php if (isset($_POST["nacimiento"]) && $_POST["nacimiento"] == "Granada") echo "selected"?>>Granada</option>
				<option value="Cádiz" <?php if (isset($_POST["nacimiento"]) && $_POST["nacimiento"] == "Cádiz") echo "selected"?>>Cadiz</option>
			</select>
			<br/>
			<br/>
			<label for="comentarios">Comentarios: </label>
			<?php
			if(isset($_POST["comentarios"])) echo $_POST["comentarios"]
			?>
			<textarea id="comentarios" rows="5" cols="30" name="comentarios"><?php if(isset($_POST["comentarios"])) echo $_POST["comentarios"]?></textarea>
			<br/>
			<br/>
			<input type="checkbox" id="suscribirse" name="suscripcion" checked>
			<label for="suscribirse">Suscribirse al boletín de Novedades.</label>
			<br/>
			<br/>
			<!--IMPORTANTE PONER EL ATRIBUTO "name" AL BOTÓN SUBMIT PARA ENVIAR LOS DATOS-->
			<button type="submit" name="btnGuardar">Guardar Cambios</button>
			<button type="submit" name="btnReset">Borrar los datos introducidos</button>
		</form>
	</body>
</html>

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
			<input type="text" id="nombre" name="nombre"/>
			<br/>
			<label for="apellidos">Apellidos</label>
			<br/>
			<input type="text" id="apellidos" size="50" name="apellidos"/>
			<br/>
			<label for="contrasena">Contraseña</label>
			<br/>
			<input type="password" id="contrasena" name="contrasena"/>
			<br/>
			<label for="dni">DNI</label>
			<br/>
			<input type="text" id="dni" size="10" maxlength="9" name="dni"/>
			<br/>
			<label id="sexo">Sexo</label>
			<br/>
			<!--PONER "value" A LOS INPUT DE TIPO RADIO-->
			<input type="radio" name="sexo" id="hombre" value="hombre"/><label for="hombre">Hombre</label>
			<br/>
			<input type="radio" name="sexo" id="mujer" value="mujer"/><label for="mujer">Mujer</label>
			<br/>
			<!--EL ATRIBUTO "accept" SIRVE PARA FILTRAR EL TIPO DE ARCHIVO QUE PUEDE ADJUNTAR EL USUARIO.-->
			<a for="foto">Incluir mi foto: </a><input type="file" id="foto" name="foto" accept="image/*"/>
			<br/>
			<br/>
			<label for="nacimiento">Nacido en: </label>
			<select id="nacimiento" name="nacimiento">
				<option value="Málaga" selected>Málaga</option>
				<option value="Granada">Granada</option>
				<option value="Cádiz">Cadiz</option>
			</select>
			<br/>
			<br/>
			<label for="comentarios">Comentarios: </label>
			<textarea id="comentarios" rows="5" cols="30" name="comentarios"></textarea>
			<br/>
			<br/>
			<input type="checkbox" id="suscribirse" name="suscripcion" checked>
			<label for="suscribirse">Suscribirse al boletín de Novedades.</label>
			<br/>
			<br/>
			<!--IMPORTANTE PONER EL ATRIBUTO "name" AL BOTÓN SUBMIT PARA ENVIAR LOS DATOS-->
			<button type="submit" name="btnGuardar">Guardar Cambios</button>
			<button type="reset">Borrar los datos introducidos</button>
		</form>
	</body>
</html>

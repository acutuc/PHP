<?php
require "src/bd_config.php";
function pag_error($title, $encabezado, $mensaje)
{
	return "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'/><title>" . $title . "</title></head><body><h1>" . $encabezado . "</h1><p>" . $mensaje . "</p></body></html>";
}




if (isset($_POST["usuario_nuevo"]))
	$mensaje_accion = "Usuario registrado con éxito";



if (isset($_POST["btnContinuarBorrar"])) {
	try {
		$conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
		mysqli_set_charset($conexion, "utf8");
	} catch (Exception $e) {
		die(pag_error("Práctica 1º CRUD", "Listado de los usuarios", "Imposible conectar. Error Nº " . mysqli_connect_errno() . " : " . mysqli_connect_error()));
	}

	$consulta = "delete from usuarios where id_usuario='" . $_POST["btnContinuarBorrar"] . "'";
	try {
		$resultado = mysqli_query($conexion, $consulta);
		$mensaje_accion = "Usuario borrado con Éxito";
	} catch (Exception $e) {
		$mensaje = "Imposible realizar la consulta. Error Nº " . mysqli_errno($conexion) . " : " . mysqli_error($conexion);
		mysqli_close($conexion);
		die(pag_error("Práctica 1º CRUD", "Listado de los usuarios", $mensaje));
	}
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8" />
	<title>Práctica 1º CRUD</title>
	<style>
		table,
		th,
		td {
			border: 1px solid black;
		}

		table {
			border-collapse: collapse
		}

		td img {
			height: 75px
		}

		.txt_centrado {
			text-align: center;
		}

		.centrar {
			width: 80%;
			margin: 1em auto;
		}

		.enlace {
			border: none;
			background: none;
			text-decoration: underline;
			color: blue;
			cursor: pointer
		}
	</style>
</head>

<body>
	<h1 class='txt_centrado'>Listado de los usuarios</h1>
	<?php
	if (!isset($conexion)) {
		try {
			$conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
			mysqli_set_charset($conexion, "utf8");
		} catch (Exception $e) {
			die("<p>Imposible conectar. Error Nº " . mysqli_connect_errno() . " : " . mysqli_connect_error() . "</p>");
		}
	}

	$consulta = "select * from usuarios";

	try {
		$resultado = mysqli_query($conexion, $consulta);
		echo "<table class='txt_centrado centrar'>";
		echo "<tr><th>Nombre de Usuario</th><th>Borrar</th><th>Editar</th></tr>";
		while ($tupla = mysqli_fetch_assoc($resultado)) {
			echo "<tr>";
			echo "<td><form action='index.php' method='post'><button type='submit' class='enlace' name='btnListar' value='" . $tupla["id_usuario"] . "'>" . $tupla["nombre"] . "</button></form></td>";
			echo "<td><form action='index.php' method='post'>";
			echo "<input type='hidden' name='nombre' value='" . $tupla["nombre"] . "'/>";
			echo "<button type='submit' name='btnBorrar' value='" . $tupla["id_usuario"] . "'><img src='img/borrar.png' alt='Borrar' title='Borrar usuario'/></button></form></td>";
			echo "<td><form action='index.php' method='post'><button type='submit' name='btnEditar' value='" . $tupla["nombre"] . "'><img src='img/editar.png' alt='Editar' title='Editar usuario'/></button></form></td>";
			echo "</tr>";
		}
		echo "</table>";

		mysqli_free_result($resultado);


		if (isset($mensaje_accion))
			echo "<p class='centrar'>" . $mensaje_accion . "</p>";


		if (isset($_POST["btnListar"])) {
			echo "<h2 class='centrar'>Listado del Usuario " . $_POST["btnListar"] . "</h2>";
			$consulta = "select * from usuarios where id_usuario='" . $_POST["btnListar"] . "'";
			try {
				$resultado = mysqli_query($conexion, $consulta);
				echo "<div class='centrar'>";
				if (mysqli_num_rows($resultado) > 0) {
					$datos_usuario = mysqli_fetch_assoc($resultado);

					echo "<p><strong>Nombre: </strong>" . $datos_usuario["nombre"] . "</p>";
					echo "<p><strong>Usuario: </strong>" . $datos_usuario["usuario"] . "</p>";
					echo "<p><strong>Email: </strong>" . $datos_usuario["email"] . "</p>";
				} else {
					echo "<p>El Usuario seleccionado ya no se encuentra registrado en la BD</p>";
				}
				echo "<form method='post' action='index.php'>";
				echo "<p><button type='submit'>Volver</button></p>";
				echo "</form>";
				echo "</div>";
				mysqli_free_result($resultado);
			} catch (Exception $e) {
				$mensaje = "<p>Imposible realizar la consulta. Error Nº " . mysqli_errno($conexion) . " : " . mysqli_error($conexion) . "</p>";
				mysqli_close($conexion);
				die($mensaje);
			}
		} elseif (isset($_POST["btnBorrar"])) {
			echo "<p class='centrar'>Se dispone usted a borrar al usuario <strong>" . $_POST["nombre"] . "</strong></p>";
			echo "<form class='centrar' method='post' action='index.php'>";
			echo "<p><button type='submit'>Volver</button><button type='submit' value='" . $_POST["btnBorrar"] . "' name='btnContinuarBorrar'>Continuar</button></p>";
			echo "</form>";
		} elseif (isset($_POST["btnEditar"]) || (isset($_POST["btnContinuarEditar"]) && $error_form_editar)) {
			if (isset($_POST["btnEditar"])) {
				$consulta = "select * from usuarios where id_usuario='" . $_POST["btnListar"] . "'";
				try {
					$resultado = mysqli_query($conexion, $consulta);
					if (mysqli_num_rows($resultado) > 0) {
						$datos_usuario = mysqli_fetch_assoc($resultado);
						$id_usuario = $datos_usuario["id_usuario"];
						$nombre = $datos_usuario["nombre"];
						$usuario = $datos_usuario["usuario"];
						$email = $datos_usuario["email"];
					} else {
						$error_consistencia = "El Usuario seleccionado ya no se encuentra registrado en la BD";
					}
					mysqli_free_result($resultado);
				} catch (Exception $e) {
					$mensaje = "<p>Imposible realizar la consulta. Error Nº " . mysqli_errno($conexion) . " : " . mysqli_error($conexion) . "</p>";
					mysqli_close($conexion);
					die($mensaje);
				}
			} else {
				$id_usuario = $_POST["btnContinuarEditar"];
				$nombre = $_POST["nombre"];
				$usuario = $_POST["usuario"];
				$email = $_POST["email"];
			}

			echo "<h2 class='centrar'>Editando el Usuario " . $_POST["btnEditar"] . "</h2>";
			if(isset($error_consistencia)){
				echo "<p class='centrar'>".$error_consistencia."</p>";
				echo "<form method='post' action='index.php'>";

			}else{

	?>
			<form action="index.php" method="post">
				<p>
					<label for="nombre">Nombre:</label>
					<input type="text" name="nombre" id="nombre" value="<?php if (isset($_POST["nombre"])) echo $nombre; ?>" maxlength="30" />
					<?php
					if (isset($_POST["nombre"]) && $error_nombre)
						echo "<span class='error'> Campo vacío </span>";
					?>
				</p>
				<p>
					<label for="usuario">Usuario:</label>
					<input type="text" name="usuario" id="usuario" value="<?php if (isset($_POST["usuario"])) echo $usuario; ?>" maxlength="20" />
					<?php
					if (isset($_POST["usuario"]) && $error_usuario)
						if ($_POST["usuario"] == "")
							echo "<span class='error'> Campo vacío </span>";
						else
							echo "<span class='error'> Usuario repetido </span>";
					?>
				</p>
				<p>
					<label for="clave">Contraseña:</label>
					<input type="password" placeholder="Editar contraseña" name="clave" id="clave" value="" maxlength="20" />
				</p>
				<p>
					<label for="email">E-mail:</label>
					<input type="text" name="email" id="email" value="<?php if (isset($_POST["email"])) echo $email; ?>" maxlength="50" />
					<?php
					if (isset($_POST["email"]) && $error_email) {
						if ($_POST["email"] == "")
							echo "<span class='error'> Campo vacío </span>";
						elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
							echo "<span class='error'> Email sintácticamente incorrecto </span>";
						else
							echo "<span class='error'> Email repetido </span>";
					}
					?>
				</p>
				<p>
					<button type="submit" name="btnVolver">Volver</button>
					<button type="submit" value="<?php echo $id_usuario ?>" name="btnContinuar">Continuar</button>
				</p>
			</form>
	<?php
			}
		} else {
			echo "<form class='centrar' action='usuario_nuevo.php' method='post'>";
			echo "<button type='submit' name='btnNuevo'>Insertar Nuevo Usuario</button>";
			echo "</form>";
		}

		mysqli_close($conexion);
	} catch (Exception $e) {
		$mensaje = "<p>Imposible realizar la consulta. Error Nº " . mysqli_errno($conexion) . " : " . mysqli_error($conexion) . "</p>";
		mysqli_close($conexion);
		die($mensaje);
	}

	?>
</body>

</html>
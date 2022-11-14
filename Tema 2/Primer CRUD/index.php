<?php
	require "src/bd_config.php";
	function pag_error($title,$encabezado,$mensaje)
	{
		return "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'/><title>".$title."</title></head><body><h1>".$encabezado."</h1><p>".$mensaje."</p></body></html>";
		
	}

	if(isset($_POST["btnContinuarBorrar"]))
	{
		try
		{
			$conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
			mysqli_set_charset($conexion,"utf8");
		
		}
		catch(Exception $e)
		{
			die(pag_error("Práctica 1º CRUD","Listado de los usuarios","Imposible conectar. Error Nº ".mysqli_connect_errno()." : ".mysqli_connect_error())); 
		}
		
		$consulta="delete from usuarios where id_usuario='".$_POST["btnContinuarBorrar"]."'";
		try
		{
				$resultado=mysqli_query($conexion,$consulta);
				$mensaje_accion="Usuario borrado con Éxito";

		}
		catch(Exception $e)
		{
			$mensaje="Imposible realizar la consulta. Error Nº ".mysqli_errno($conexion)." : ".mysqli__error($conexion);
			mysqli_close($conexion);
			die(pag_error("Práctica 1º CRUD","Listado de los usuarios",$mensaje)); 
		}
	}
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8"/>
		<title>Práctica 1º CRUD</title>
		<style>
			table,th,td{border:1px solid black;}
			table{border-collapse:collapse}
			td img{height:75px}
			.txt_centrado{ text-align:center;}
			.centrar{width:80%;margin:1em auto;}
			.enlace{border:none;background:none;text-decoration:underline;color:blue;cursor:pointer}
		</style>
	</head>
	<body>
		<h1 class='txt_centrado'>Listado de los usuarios</h1>
		<?php
			if(!isset($conexion))
			{
				try
				{
					$conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
					mysqli_set_charset($conexion,"utf8");
				
				}
				catch(Exception $e)
				{
					die("<p>Imposible conectar. Error Nº ".mysqli_connect_errno()." : ".mysqli_connect_error()."</p>"); 
				}
			}
			
			$consulta="select * from usuarios";
			
			
			try
			{
				$resultado=mysqli_query($conexion,$consulta);
				echo "<table class='txt_centrado centrar'>";
				echo "<tr><th>Nombre de Usuario</th><th>Borrar</th><th>Editar</th></tr>";
				while($tupla=mysqli_fetch_assoc($resultado))
				{
					echo "<tr>";
					echo "<td><form action='index.php' method='post'><button type='submit' class='enlace' name='btnListar' value='".$tupla["id_usuario"]."'>".$tupla["nombre"]."</button></form></td>";
					echo "<td><form action='index.php' method='post'>";
					echo "<input type='hidden' name='nombre' value='".$tupla["nombre"]."'/>";
					echo "<button type='submit' name='btnBorrar' value='".$tupla["id_usuario"]."'><img src='img/borrar.png' alt='Borrar' title='Borrar usuario'/></button></form></td>";
					echo "<td><form action='index.php' method='post'><button type='submit' name='btnEditar' value='".$tupla["id_usuario"]."'><img src='img/editar.png' alt='Editar' title='Editar usuario'/></button></form></td>";
					echo "</tr>";
				}
				echo "</table>";
				
				mysqli_free_result($resultado);
				
				
				if(isset($_POST["usuario_nuevo"]))
					echo "<p class='centrar'>Usuario registrado con éxito</p>";
				
				if(isset($mensaje_accion))
					echo "<p class='centrar'>".$mensaje_accion."</p>";


				if(isset($_POST["btnListar"]))
				{
					echo "<h2 class='centrar'>Listado del Usuario ".$_POST["btnListar"]."</h2>";
					$consulta="select * from usuarios where id_usuario='".$_POST["btnListar"]."'";
					try{
						$resultado=mysqli_query($conexion,$consulta);
						echo "<div class='centrar'>";
						if(mysqli_num_rows($resultado)>0)
						{
							$datos_usuario=mysqli_fetch_assoc($resultado);
						
							echo "<p><strong>Nombre: </strong>".$datos_usuario["nombre"]."</p>";
							echo "<p><strong>Usuario: </strong>".$datos_usuario["usuario"]."</p>";
							echo "<p><strong>Email: </strong>".$datos_usuario["email"]."</p>";
						}
						else
						{
							echo "<p>El Usuario seleccionado ya no se encuentra registrado en la BD</p>";
						}
						echo "<form method='post' action='index.php'>";
						echo "<p><button type='submit'>Volver</button></p>";
						echo "</form>";
						echo "</div>";
						mysqli_free_result($resultado);
					}
					catch(Exception $e)
					{
						$mensaje="<p>Imposible realizar la consulta. Error Nº ".mysqli_errno($conexion)." : ".mysqli_error($conexion)."</p>";
						mysqli_close($conexion);
						die($mensaje); 
					}
				}
				elseif(isset($_POST["btnBorrar"]))
				{
					echo "<p class='centrar'>Se dispone usted a borrar al usuario <strong>".$_POST["nombre"]."</strong></p>";
					echo "<form class='centrar' method='post' action='index.php'>";
					echo "<p><button type='submit'>Volver</button><button type='submit' value='".$_POST["btnBorrar"]."' name='btnContinuarBorrar'>Continuar</button></p>";
					echo "</form>";
				}
				elseif(isset($_POST["btnEditar"]))
				{
					echo "<h2 class='centrar'>Editando el Usuario ".$_POST["btnEditar"]."</h2>";
					
				}
				else
				{
					echo "<form class='centrar' action='usuario_nuevo.php' method='post'>";
					echo "<button type='submit' name='btnNuevo'>Insertar Nuevo Usuario</button>";
					echo "</form>";
				}
				
				mysqli_close($conexion);
			}
			catch(Exception $e)
			{
				$mensaje="<p>Imposible realizar la consulta. Error Nº ".mysqli_errno($conexion)." : ".mysqli_error($conexion)."</p>";
				mysqli_close($conexion);
				die($mensaje); 
			}
			
		?>
	</body>
</html>

<?php
    require "src/bd_config.php";
    require "src/funciones.php";

    if(isset($_POST["btnContEditar"]))
    {
        $error_nombre=$_POST["nombre"]=="";
        $error_usuario=$_POST["usuario"]=="";
        $error_dni=$_POST["dni"]==""||!bien_escrito_dni($_POST["dni"]) || strtoupper(substr($_POST["dni"],8,1))!=LetraNIF(substr($_POST["dni"],0,8));
        $error_foto=$_FILES["foto"]["name"]!="" && ($_FILES["foto"]["error"]||!getimagesize($_FILES["foto"]["tmp_name"])||$_FILES["foto"]["size"]>500*1000);

        if(!$error_usuario||!$error_dni)
        {
            try
			{
				$conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
				mysqli_set_charset($conexion,"utf8");
				
			}
			catch(Exception $e)
			{
				die(pag_error("Práctica 8","Práctica 8","Imposible conectar. Error Nº ".mysqli_connect_errno()." : ".mysqli_connect_error())); 
			}
			
			if(!$error_usuario)
			{
				$error_usuario=repetido($conexion, "usuarios","usuario",$_POST["usuario"],"id_usuario",$_POST["btnContEditar"]);
			
				if(is_string($error_usuario))
				{
						mysqli_close($conexion);
						die(pag_error("Práctica 8","Práctica 8",$error_usuario)); 
				}
			}
			if(!$error_dni)
			{
				$error_dni=repetido($conexion, "usuarios","dni",$_POST["dni"],"id_usuario",$_POST["btnContEditar"]);
				
				if(is_string($error_dni))
				{
					mysqli_close($conexion);
					die(pag_error("Práctica 8","Práctica 8",$error_dni)); 
				}
			}	

        }

        $errores_form_editar=$error_nombre||$error_usuario ||$error_dni||$error_foto;
        if(!$errores_form_editar)
        {
            
            if($_POST["clave"]=="")
                $consulta="update usuarios set nombre='".$_POST["nombre"]."', usuario='".$_POST["usuario"]."', dni='".strtoupper($_POST["dni"])."', sexo='".$_POST["sexo"]."' where id_usuario='".$_POST["btnContEditar"]."'";
            else
                $consulta="update usuarios set nombre='".$_POST["nombre"]."', usuario='".$_POST["usuario"]."', clave='".md5($_POST["clave"])."', dni='".strtoupper($_POST["dni"])."', sexo='".$_POST["sexo"]."' where id_usuario='".$_POST["btnContEditar"]."'";

            try
            {
                mysqli_query($conexion,$consulta);
                $mensaje_accion="Usuario editado con Éxito";
                if($_FILES["foto"]["name"]!="")
                {
                   
                    $arr_nombre=explode(".",$_FILES["foto"]["name"]);
                    $ext="";
                    if(count($arr_nombre)>1)
                            $ext=".".end($arr_nombre);
                        
                        $nuevo_nombre="img_".$_POST["btnContEditar"].$ext;
                        @$var=move_uploaded_file($_FILES["foto"]["tmp_name"],"Img/".$nuevo_nombre);
                        if($var)
                        {
                            if($nuevo_nombre!=$_POST["nombre_foto"])    
                            {
                                try
                                {
                                    $consulta="update usuarios set foto='".$nuevo_nombre."' where id_usuario='".$_POST["btnContEditar"]."'";
                                    mysqli_query($conexion,$consulta);
                                    if($_POST["nombre_foto"]!="no_imagen.jpg")
                                        unlink("Img/".$_POST["nombre_foto"]);

                                }
                                catch(Exception $e)
                                {
                                    $mensaje="Imposible realizar la consulta. Error Nº ".mysqli_errno($conexion)." : ".mysqli__error($conexion);
                                    mysqli_close($conexion);
                                    die(pag_error("Práctica 8","Práctica 8",$mensaje)); 
                                }
                            }
                        }
                        else
                        {
                            $mensaje_accion="Usuario editado con Éxito sin cambio de foto, por no poder mover foto elegida en el servidor";
                        }
                }

            }
            catch(Exception $e)
            {
                $mensaje="Imposible realizar la consulta. Error Nº ".mysqli_errno($conexion)." : ".mysqli__error($conexion);
                mysqli_close($conexion);
                die(pag_error("Práctica 8","Práctica 8",$mensaje)); 
            }
        }

    }


    if(isset($_POST["btnContNuevo"]))
    {
        $error_nombre=$_POST["nombre"]=="";
        $error_usuario=$_POST["usuario"]=="";
        $error_clave=$_POST["clave"]=="";
        $error_dni=$_POST["dni"]==""||!bien_escrito_dni($_POST["dni"]) || strtoupper(substr($_POST["dni"],8,1))!=LetraNIF(substr($_POST["dni"],0,8));
        $error_foto=$_FILES["foto"]["name"]!="" && ($_FILES["foto"]["error"]||!getimagesize($_FILES["foto"]["tmp_name"])||$_FILES["foto"]["size"]>500*1000);

        if(!$error_usuario||!$error_dni)
        {
            try
			{
				$conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
				mysqli_set_charset($conexion,"utf8");
				
			}
			catch(Exception $e)
			{
				die(pag_error("Práctica 8","Práctica 8","Imposible conectar. Error Nº ".mysqli_connect_errno()." : ".mysqli_connect_error())); 
			}
			
			if(!$error_usuario)
			{
				$error_usuario=repetido($conexion, "usuarios","usuario",$_POST["usuario"]);
			
				if(is_string($error_usuario))
				{
						mysqli_close($conexion);
						die(pag_error("Práctica 8","Práctica 8",$error_usuario)); 
				}
			}
			if(!$error_dni)
			{
				$error_dni=repetido($conexion, "usuarios","dni",$_POST["dni"]);
				
				if(is_string($error_dni))
				{
					mysqli_close($conexion);
					die(pag_error("Práctica 8","Práctica 8",$error_dni)); 
				}
			}	

        }

        $error_form_insert= $error_nombre||$error_usuario|| $error_clave ||$error_dni||$error_foto;
        if(!$error_form_insert)
        {
            
            $consulta="insert into usuarios(nombre,usuario,clave,dni,sexo) values('".$_POST["nombre"]."','".$_POST["usuario"]."','".md5($_POST["clave"])."','".strtoupper($_POST["dni"])."','".$_POST["sexo"]."')";
            try
            {
                    mysqli_query($conexion,$consulta);
                    $mensaje_accion="Usuario insertado con Éxito";
                    if($_FILES["foto"]["name"]!="")
                    {
                        $ultimo_id=mysqli_insert_id($conexion);
                        $arr_nombre=explode(".",$_FILES["foto"]["name"]);
                        $ext="";
                        if(count($arr_nombre)>1)
                            $ext=".".end($arr_nombre);
                        
                        $nuevo_nombre="img_".$ultimo_id.$ext;
                        @$var=move_uploaded_file($_FILES["foto"]["tmp_name"],"Img/".$nuevo_nombre);
                        if($var)
                        {
                            try
                            {
                                $consulta="update usuarios set foto='".$nuevo_nombre."' where id_usuario='".$ultimo_id."'";
                                mysqli_query($conexion,$consulta);
                            }
                            catch(Exception $e)
                            {
                                $mensaje="Imposible realizar la consulta. Error Nº ".mysqli_errno($conexion)." : ".mysqli__error($conexion);
                                mysqli_close($conexion);
                                die(pag_error("Práctica 8","Práctica 8",$mensaje)); 
                            }
                        }
                        else
                        {
                            $mensaje_accion="Usuario insertado con Éxito con foto por defecto, por no poder mover foto elegida en el servidor";
                        }

                    }
            }
            catch(Exception $e)
            {
                $mensaje="Imposible realizar la consulta. Error Nº ".mysqli_errno($conexion)." : ".mysqli__error($conexion);
                mysqli_close($conexion);
                die(pag_error("Práctica 8","Práctica 8",$mensaje)); 
            }


        }
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
			die(pag_error("Práctica 8","Práctica 8","Imposible conectar. Error Nº ".mysqli_connect_errno()." : ".mysqli_connect_error())); 
		}
		
		$consulta="delete from usuarios where id_usuario='".$_POST["btnContinuarBorrar"]."'";
		try
		{
				mysqli_query($conexion,$consulta);
				$mensaje_accion="Usuario borrado con Éxito";
                if($_POST["nombre_foto"]!="no_imagen.jpg")
                    unlink("Img/".$_POST["nombre_foto"]);

		}
		catch(Exception $e)
		{
			$mensaje="Imposible realizar la consulta. Error Nº ".mysqli_errno($conexion)." : ".mysqli__error($conexion);
			mysqli_close($conexion);
			die(pag_error("Práctica 8","Práctica 8",$mensaje)); 
		}
	}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 8</title>
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

    .img_listar {
        height: 125px;
        float: left;
        border: 1px solid black;
        margin-right: 2em
    }
    </style>
</head>

<body>
    <h1 class="txt_centrado">Práctica 8</h1>
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
            die("<p class='centrar'>Imposible conectar. Error Nº ".mysqli_connect_errno()." : ".mysqli_connect_error()."</p>"); 
        }
    }

    if(isset($_POST["btnInsertarUsuario"]) || (isset($_POST["btnContNuevo"]) && $error_form_insert))
    {
    ?>
        <h2 class='centrar'>Agregar Nuevo Usuario</h2>
        <form class='centrar' method="post" action="index.php" enctype="multipart/form-data">

            <p><label for="nombre">Nombre: </label><br />
            <input type="text" name="nombre" id="nombre" placeholder="Nombre..." size="30" value="<?php if(isset($_POST["nombre"])) echo $_POST["nombre"];?>"/>
            <?php
                if(isset($_POST["nombre"]) && $error_nombre)
                    echo "<span class='error'>* Campo vacío *</span>";
            ?>
            </p>
            <p>
            <label for="usuario">Usuario: </label><br />
            <input type="text" name="usuario" id="usuario" placeholder="Usuario..." value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"];?>"/>
            <?php
                if(isset($_POST["usuario"]) && $error_usuario)
                    if($_POST["usuario"]=="")
                        echo "<span class='error'>* Campo vacío *</span>";
                    else echo "<span class='error'>* Usuario repetido *</span>";
            ?>
            </p>
            <p>
            <label for="clave">Contraseña: </label><br />
            <input type="password" name="clave" id="clave" placeholder="Contraseña..." />
            <?php
                if(isset($_POST["clave"]) && $error_clave)
                    echo "<span class='error'>* Campo vacío *</span>";
            ?>
            </p>
            <p>
            <label for="dni">DNI: </label><br />
            <input type="dni" name="dni" id="dni" placeholder="DNI: 11223344A" value="<?php if(isset($_POST["dni"])) echo $_POST["dni"];?>"/>
            <?php
                if(isset($_POST["dni"]) && $error_dni)
                {
                    if($_POST["dni"]=="")
                        echo "<span class='error'>* Campo vacío *</span>";
                    elseif(!bien_escrito_dni($_POST["dni"]))
                        echo "<span class='error'>* Dni no está bien escrito*</span>";
                    elseif(strtoupper(substr($_POST["dni"],8,1))!=LetraNIF(substr($_POST["dni"],0,8)))
                        echo "<span class='error'>* DNI no válido *</span>";
                    else
                        echo "<span class='error'>* DNI repetido *</span>";
                }
            ?>
            </p>
            <p>
            <label>Sexo</label><br />
            <input type="radio" name="sexo" value="hombre" id="hombre" <?php if(!isset($_POST["sexo"]) || $_POST["sexo"]=="hombre") echo "checked";?>/>
            <label for="hombre">Hombre: </label> <br />
            
            <input type="radio" name="sexo" value="mujer" id="mujer" <?php if(isset($_POST["sexo"]) && $_POST["sexo"]=="mujer") echo "checked";?>/>
            <label for="mujer">Mujer: </label>

            </p>
            <p>
            <label for="foto">Incluir mi foto (Max. 500KB)</label>
            <input type="file" name="foto" id="foto" accept="image/*"/>			
            <?php
            if(isset($_POST["btnContNuevo"])&& $error_foto)
            {
                if($_FILES["foto"]["error"])
                    echo "<span class=''>* Error en la subida del fichero *</span>";
                elseif(!getimagesize($_FILES["foto"]["tmp_name"]))
                    echo "<span class=''>* El fichero subido no es un archivo imagen *</span>";
                else
                    echo "<span class=''>* El tamaño del fichero supera los 500KB *</span>";
            }

            ?>
            </p>
            <p>
            <input type="submit" value="Volver" />
            <input type="submit" value="Guardar Cambios" name="btnContNuevo" />
           
            </p>

    </form>

    <?php
    }

    if(isset($_POST["btnEditar"])|| (isset($_POST["btnContEditar"])&& $errores_form_editar))
    {
        if(isset($_POST["btnEditar"]))
        {
            $id_usuario=$_POST["btnEditar"];
            $consulta="select * from usuarios where id_usuario='".$id_usuario."'";
            try{
                $resultado=mysqli_query($conexion,$consulta);
                
                if(mysqli_num_rows($resultado)>0)
                {
                    $datos_usuario=mysqli_fetch_assoc($resultado);
                    $nombre=$datos_usuario["nombre"];
                    $usuario=$datos_usuario["usuario"];
                    $dni=$datos_usuario["dni"];
                    $sexo=$datos_usuario["sexo"];
                    $nombre_foto=$datos_usuario["foto"];
                    
                }
                else
                {
                    $error_consistencia="El Usuario seleccionado ya no se encuentra registrado en la BD";
                }
                
                mysqli_free_result($resultado);
            }
            catch(Exception $e)
            {
                $mensaje="<p>Imposible realizar la consulta. Error Nº ".mysqli_errno($conexion)." : ".mysqli_error($conexion)."</p>";
                mysqli_close($conexion);
                die($mensaje); 
            }
        }
        else
        {
            $id_usuario=$_POST["btnContEditar"];
            $nombre=$_POST["nombre"];
            $usuario=$_POST["usuario"];
            $dni=$_POST["dni"];
            $sexo=$_POST["sexo"];
            $nombre_foto=$_POST["nombre_foto"];
        }

        echo "<h2 class='centrar'>Editando al usuario con Id: ".$id_usuario."</h2>";
        if(isset($error_consistencia))
        {
            echo "<div class='centrar'>";
            echo "<p>".$error_consistencia."</p>";
            echo "<form method='post' action='index.php'>";
            echo "<p><button type='submit'>Volver</button></p>";
            echo "</form>";
            echo "</div>";
        }
        else
        {
        ?>
            <form class='centrar' method="post" action="index.php" enctype="multipart/form-data">

            <p><label for="nombre">Nombre: </label><br />
            <input type="text" name="nombre" id="nombre" placeholder="Nombre..." size="30" value="<?php echo $nombre;?>"/>
            <?php
                if(isset($_POST["nombre"]) && $error_nombre)
                    echo "<span class='error'>* Campo vacío *</span>";
            ?>
            </p>
            <p>
            <label for="usuario">Usuario: </label><br />
            <input type="text" name="usuario" id="usuario" placeholder="Usuario..." value="<?php echo $usuario;?>"/>
            <?php
                if(isset($_POST["usuario"]) && $error_usuario)
                    if($_POST["usuario"]=="")
                        echo "<span class='error'>* Campo vacío *</span>";
                    else echo "<span class='error'>* Usuario repetido *</span>";
            ?>
            </p>
            <p>
            <label for="clave">Contraseña: </label><br />
            <input type="password" name="clave" id="clave" placeholder="Edite su contraseña..." />
           
            </p>
            <p>
            <label for="dni">DNI: </label><br />
            <input type="dni" name="dni" id="dni" placeholder="DNI: 11223344A" value="<?php echo $dni;?>"/>
            <?php
                if(isset($_POST["dni"]) && $error_dni)
                {
                    if($_POST["dni"]=="")
                        echo "<span class='error'>* Campo vacío *</span>";
                    elseif(!bien_escrito_dni($_POST["dni"]))
                        echo "<span class='error'>* Dni no está bien escrito*</span>";
                    elseif(strtoupper(substr($_POST["dni"],8,1))!=LetraNIF(substr($_POST["dni"],0,8)))
                        echo "<span class='error'>* DNI no válido *</span>";
                    else
                        echo "<span class='error'>* DNI repetido *</span>";
                }
            ?>
            </p>
            <p>
            <label>Sexo</label><br />
            <input type="radio" name="sexo" value="hombre" id="hombre" <?php if($sexo=="hombre") echo "checked";?>/>
            <label for="hombre">Hombre: </label> <br />

            <input type="radio" name="sexo" value="mujer" id="mujer" <?php if($sexo=="mujer") echo "checked";?>/>
            <label for="mujer">Mujer: </label>

            </p>
            <p>
            <label for="foto">Incluir mi foto (Max. 500KB)</label>
            <input type="file" name="foto" id="foto" accept="image/*"/>			
            <?php
            if(isset($_POST["btnContNuevo"])&& $error_foto)
            {
                if($_FILES["foto"]["error"])
                    echo "<span class=''>* Error en la subida del fichero *</span>";
                elseif(!getimagesize($_FILES["foto"]["tmp_name"]))
                    echo "<span class=''>* El fichero subido no es un archivo imagen *</span>";
                else
                    echo "<span class=''>* El tamaño del fichero supera los 500KB *</span>";
            }

            ?>
            </p>
            <p>
            <input type="submit" value="Volver" />
            <input type="hidden" name="nombre_foto" value="<?php echo $nombre_foto;?>"/>
            <button type="submit" value="<?php echo $id_usuario;?>" name="btnContEditar">Continuar</button>

            </p>

            </form>


         <?php   
        }
    }

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
            
                echo "<p><img class='img_listar' src='Img/".$datos_usuario["foto"]."' alt='Foto de Perfil' title='Foto de Perfil'/>";
                echo "<strong>Nombre: </strong>".$datos_usuario["nombre"]."<br/><br/>";
                echo "<strong>Usuario: </strong>".$datos_usuario["usuario"]."<br/><br/>";
                echo "<strong>DNI: </strong>".$datos_usuario["dni"]."<br/><br/>";
                echo "<strong>Sexo: </strong>".$datos_usuario["sexo"]."</p>";
                
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

    if(isset($_POST["btnBorrar"]))
    {
        echo "<div class='centrar'>";
        echo "<h2>Borrado del usuario con ID: ".$_POST["btnBorrar"]."</h2>";
        echo "<p>¿ Está ústed seguro ?</p>";
        echo "<form method='post' action='index.php'>";
        echo "<p><input type='hidden' name='nombre_foto' value='".$_POST["nombre_foto"]."'/><button type='submit'>Volver</button> <button type='submit' value='".$_POST["btnBorrar"]."' name='btnContinuarBorrar'>Continuar</button></p>";
        echo "</form></div>";
    }

    try
    {
        $consulta="select * from usuarios";
        $resultado=mysqli_query($conexion,$consulta);
        echo "<h3 class='centrar'>Listado de los Usuarios</h3>";
        echo "<table class='txt_centrado centrar'>";
        echo "<tr><th>#</th><th>Foto</th><th>Nombre</th><th><form action='index.php' method='post'><button class='enlace' type='submit' name='btnInsertarUsuario'>Usuario+</button></form></th></tr>";
        while($tupla=mysqli_fetch_assoc($resultado))
        {
            echo "<tr>";
            echo "<td>".$tupla["id_usuario"]."</td>";
            echo "<td><img src='Img/".$tupla["foto"]."' alt='Foto de Perfil' title='Foto de Perfil'/></td>";
            echo "<td><form action='index.php' method='post'><button type='submit' value='".$tupla["id_usuario"]."' name='btnListar' class='enlace'>".$tupla["nombre"]."</button></form></td>";
            echo "<td><form action='index.php' method='post'><input type='hidden' name='nombre_foto' value='".$tupla["foto"]."'/><button type='submit' value='".$tupla["id_usuario"]."' name='btnBorrar' class='enlace'>Borrar</button> - <button type='submit' value='".$tupla["id_usuario"]."' name='btnEditar' class='enlace'>Editar</button></form></td>";
            echo "</tr>";
        }
        echo "</table>";
        mysqli_free_result($resultado);
        mysqli_close($conexion);

        
    }
    catch(Exception $e)
    {
        $mensaje="<p>Imposible realizar la consulta. Error Nº ".mysqli_errno($conexion)." : ".mysqli_error($conexion)."</p>";
		mysqli_close($conexion);
		die($mensaje); 
    }

    if(isset($mensaje_accion))
        echo "<p class='centrar'>".$mensaje_accion."</p>";

    ?>
</body>

</html>
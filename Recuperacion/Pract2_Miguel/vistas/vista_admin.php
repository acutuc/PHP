<?php
//Aquí haremos el btnContBorrar para hacer el header location, que va antes de cualquier código HTML:
if (isset($_POST["btnContBorrar"])) {
    try {
        $consulta = "DELETE FROM usuarios WHERE id_usuario = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$_POST["btnContBorrar"]]);
        $sentencia = null;
        //Si el nombre de la foto es diferente a "no_imagen.jpg", es que el usuario tiene foto:
        if ($_POST["foto"] != "no_imagen.jpg") {
            //Aquí ponemos el $_POST["foto"] que  hemos venido arrastrando con el input hidden:
            unlink("Img/" . $_POST["foto"]);
        }
        $_SESSION["accion"] = "El usuario ha sido borrado con éxito.";
        header("Location:index.php");
        exit();
    } catch (PDOException $e) {
        session_destroy();
        $sentencia = null;
        $conexion = null;
        die(error_page("Práctica Rec 2", "Práctica Rec 2", "Imposible realizar la consulta. Error: " . $e->getMessage()));
    }
}
//Cuando pulsamos el botón Borrar mientras estamos registrando a un usuario (para que se vacíen los campos):
if(isset($_POST["btnBorrarNuevo"])){
    unset($_POST);
}

//Confirmamos registro de un nuevo usuario:
if(isset($_POST["btnContRegistro"]))
{
    //comprobar errores formulario
    $error_usuario=$_POST["usuario"]=="";
    if(!$error_usuario)
    {
        $error_usuario=repetido_reg($conexion,"usuario",$_POST["usuario"]);
        if(is_string($error_usuario))
        {
            session_destroy();
            $conexion=null;
            die(error_page("Práctica Rec 2","Práctica Rec 2",$error_usuario));
        }
    }
    $error_nombre=$_POST["nombre"]=="";
    $error_clave=$_POST["clave"]=="";
    $error_dni=$_POST["dni"]==""||!dni_bien_escrito($_POST["dni"])||!dni_valido($_POST["dni"]);
    if(!$error_dni)
    {
        if(!isset($conexion))
        {
            try
            {
                $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
            }
            catch(PDOException $e)
            {
                session_destroy();
                die(error_page("Práctica Rec 2","Práctica Rec 2","Imposible realizar la conexión. Error:".$e->getMessage()));
            }
        }

        $error_dni=repetido_reg($conexion,"dni",strtoupper($_POST["dni"]));
        if(is_string($error_dni))
        {
            session_destroy();
            $conexion=null;
            die(error_page("Práctica Rec 2","Práctica Rec 2",$error_dni));
        }
    }
    $error_sexo=!isset($_POST["sexo"]);
    $error_foto=$_FILES["foto"]["name"]!="" && ($_FILES["foto"]["error"] || !getimagesize($_FILES["foto"]["tmp_name"]) ||$_FILES["foto"]["size"] >500*1024);
    $error_form=$error_usuario||$error_nombre||$error_clave||$error_dni||$error_sexo||$error_foto;

    if(!$error_form)
    {
        try
        {
            $consulta="insert into usuarios(usuario, clave, nombre, dni,sexo, subscripcion) values(?,?,?,?,?,?)";
            $sentencia=$conexion->prepare($consulta);
            $subs=0;
            if(isset($_POST["subcripcion"]))
                $subs=1;
         
            $datos[]=$_POST["usuario"];
            $datos[]=md5($_POST["clave"]);
            $datos[]=$_POST["nombre"];
            $datos[]=strtoupper($_POST["dni"]);
            $datos[]=$_POST["sexo"];
            $datos[]=$subs;
            $sentencia->execute($datos);
            $sentencia=null;
        }
        catch(PDOException $e)
        {
            $sentencia=null;
            $conexion=null;
            session_destroy();
            die(error_page("Práctica Rec 2","Práctica Rec 2","Imposible realizar la consulta. Error:".$e->getMessage()));
        }

        $mensaje="El usuario ha sido registrado con éxito.";
        if($_FILES["foto"]["name"]!="")
        {
            $ultm_id=$conexion->lastInsertId();
            $array_ext=explode(".", $_FILES["foto"]["name"]);
            $ext="";
            if(count($array_ext)>0)
                $ext=".".end($array_ext);

            $nombre_nuevo_img="img_".$ultm_id.$ext;
            @$var=move_uploaded_file($_FILES["foto"]["tmp_name"],"Img/".$nombre_nuevo_img);
            if($var)
            {
                try
                {
                    $consulta="update usuarios set foto=? where id_usuario=?";
                    $sentencia=$conexion->prepare($consulta);
                    $sentencia->execute([$nombre_nuevo_img,$ultm_id]);
                }
                catch(PDOException $e)
                {
                    unlink("Img/".$nombre_nuevo_img);
                    $mensaje="Has sido registrado con éxito con la imagen por defecto, por un problema con la BD";
                }
                $sentencia=null;
            }
            else
                $mensaje="Has sido registrado con la imagen por defecto por no poder mover imagen a carpeta destino en el servidor";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica Rec 2</title>
    <style>
        .en_linea {
            display: inline
        }

        .enlace {
            background: none;
            border: none;
            text-decoration: underline;
            color: blue;
            cursor: pointer
        }

        #tabla_principal,
        #tabla_principal td,
        #tabla_principal th {
            border: 1px solid black
        }

        #tabla_principal {
            width: 90%;
            border-collapse: collapse;
            text-align: center;
            margin: 0 auto
        }

        #tabla_principal th {
            background-color: #CCC
        }

        #tabla_principal img {
            height: 75px
        }

        #bot_pag {
            display: flex;
            justify-content: center;
            margin-top: 1em
        }

        #bot_pag button {
            margin: 0 0.25em;
            padding: 0.25em
        }

        #form_regs_buscar {
            width: 90%;
            margin: 0.5em auto;
            display: flex;
            justify-content: space-between
        }

        .centrado {
            text-align: center;
        }

        .mensaje {
            color: blue;
            font-size: 1.25em;
        }
    </style>
</head>

<body>
    <h1>Práctica Rec 2</h1>
    <div>Bienvenido <strong>
            <?php echo $datos_usuario_log["usuario"]; ?>
        </strong> - <form method="post" action="index.php" class="en_linea"><button class="enlace"
                name="btnSalir">Salir</button></form>
    </div>
    <?php
    //Cuando pulsamos sobre un usuario para ver sus datos:
    if (isset($_POST["btnListar"])) {
        try {
            $consulta = "SELECT * FROM usuarios WHERE id_usuario = ?";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute([$_POST["btnListar"]]);

            echo "<h2>Detalles del usuario con id: " . $_POST["btnListar"] . "</h2>";
            //Si no se ha borrado el usuario:
            if ($sentencia->rowCount() > 0) {
                $datos_usuario = $sentencia->fetch(PDO::FETCH_ASSOC);
                //TERMINAR AQUÍ!!!
                echo "<p><strong>Nombre: </strong>" . $datos_usuario["nombre"] . "</p>";
                echo "<p>...................</p>";
            } else {
                //Si se ha borrado mientras consultábamos:
                echo "<p>El usuario ya no se encuentra disponible en la base de datos.</p>";
            }
            echo "<form method='post' action='index.php'><button type='submit'>Volver</button></form>";
            $sentencia = null;
        } catch (PDOException $e) {
            session_destroy();
            $sentencia = null;
            $conexion = null;
            die("<p>Imposible realizar la consulta. Error:" . $e->getMessage() . "</p></body></html>");
        }
    }

    if (isset($_POST["btnNuevo"]) || isset($_POST["btnBorrarNuevo"]) || isset($_POST["btnContNuevo"])) {
        ?>
        <h2>Registro de un nuevo usuario</h2>
        <form action="index.php" method="post" enctype="multipart/form-data">
            <p>
                <label for="usuario">Usuario:</label><br />
                <input type="text" id="usuario" name="usuario" placeholder="Usuario..." value="<?php if (isset($_POST["usuario"]))
                    echo $_POST["usuario"]; ?>" />
                <?php
                if (isset($_POST["btnContNuevo"]) && $error_usuario) {
                    if ($_POST["usuario"] == "")
                        echo "<span class='error'> Campo Vacío </span>";
                    else
                        echo "<span class='error'> Usuario repetido </span>";
                }
                ?>
            </p>
            <p>
                <label for="nombre">Nombre:</label><br />
                <input type="text" id="nombre" name="nombre" placeholder="Nombre..." value="<?php if (isset($_POST["nombre"]))
                    echo $_POST["nombre"]; ?>" />
                <?php
                if (isset($_POST["btnContNuevo"]) && $error_nombre) {
                    echo "<span class='error'> Campo Vacío </span>";
                }
                ?>
            </p>
            <p>
                <label for="clave">Contraseña:</label><br />
                <input type="password" id="clave" name="clave" placeholder="Contraseña..." value="" />
                <?php
                if (isset($_POST["btnContNuevo"]) && $error_clave) {
                    echo "<span class='error'> Campo Vacío </span>";
                }
                ?>
            </p>
            <p>
                <label for="dni">DNI:</label><br />
                <input type="text" id="dni" name="dni" placeholder="DNI: 11223344Z" value="<?php if (isset($_POST["dni"]))
                    echo $_POST["dni"]; ?>" />
                <?php
                if (isset($_POST["btnContNuevo"]) && $error_dni)
                    if ($_POST["dni"] == "")
                        echo "<span class='error'> Campo Vacío </span>";
                    else if (!dni_bien_escrito($_POST["dni"]))
                        echo "<span class='error'> DNI no está bien escrito </span>";
                    else if (!dni_valido($_POST["dni"]))
                        echo "<span class='error'> DNI no válido </span>";
                    else
                        echo "<span class='error'> DNI repetido </span>";
                ?>
            </p>
            <p>
                <label>Sexo:</label>
                <?php
                if (isset($_POST["btnContNuevo"]) && $error_sexo)
                    echo "<span class='error'> Debes seleccionar un sexo </span>";
                ?>
                <br />
                <input type="radio" <?php if (isset($_POST["sexo"]) && $_POST["sexo"] == "Hombre")
                    echo "checked"; ?>
                    name="sexo" id="hombre" value="Hombre" /> <label for="hombre">Hombre</label><br />
                <input type="radio" <?php if (isset($_POST["sexo"]) && $_POST["sexo"] == "Mujer")
                    echo "checked"; ?>
                    name="sexo" id="mujer" value="Mujer" /> <label for="mujer">Mujer</label>

            </p>
            <p>
                <label for="foto">Incluir mi foto (Máx 500 KB):</label><input type="file" id="foto" name="foto"
                    accept="image/*" />
                <?php
                if (isset($_POST["btnContNuevo"]) && $error_foto) {
                    if ($_FILES["foto"]["error"]) {
                        echo "<span class='error'> Error en la subida del fichero al servidor </span>";
                    } elseif (!getimagesize($_FILES["foto"]["tmp_name"])) {
                        echo "<span class='error'> Error, no has seleccionado un archivo imagen </span>";
                    } else
                        echo "<span class='error'> Error, el tamaño del fichero seleccionado supera los 500KB </span>";
                }
                ?>
            </p>
            <p>
                <input type="checkbox" <?php if (isset($_POST["subcripcion"]))
                    echo "checked"; ?> name="subcripcion"
                    id="sub" /> <label for="sub">Subcribirme al boletín de novedades</label>

            </p>
            <p>
                <input type="submit" name="btnContNuevo" value="Guardar Cambios" />
                <input type="submit" name="btnBorrarNuevo" value="Borrar los datos introducidos" />
                <input type="submit" name="btnVolver" value="Volver" />
            </p>
        </form>
        <?php
    }

    if (isset($_POST["btnBorrar"])) {
        echo "<div>";
        echo "<h2 class='centrado'>Borrando el usuario con id: " . $_POST["btnBorrar"] . "</h2>";
        echo "<form action='index.php' method='post'>";
        //NOS TRAEMOS EL HIDDEN DE LA FOTO:
        echo "<input type='hidden' value='" . $_POST["foto"] . "' name='foto'>";
        echo "<p class='centrado'>Se dispone usted a borrar el usuario con id " . $_POST["btnBorrar"] . "<br>";
        echo "¿Estás seguro?</p>";
        echo "<p class='centrado'><button>Cancelar</button> <button name='btnContBorrar' value='" . $_POST["btnBorrar"] . "'>Confirmar</button></p>";
        echo "</form>";
        echo "</div>";
    }

    if (isset($_POST["btnEditar"])) {

    }

    if (isset($_SESSION["accion"])) {
        echo "<p class='mensaje>" . $_SESSION["accion"] . "</p>";
        unset($_SESSION["accion"]);
    }
    ?>
    <h2>Listado de los usuarios no admin</h2>
    <?php
    require "vistas/vista_tabla_principal.php";
    ?>
</body>

</html>
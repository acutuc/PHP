<?php
require "src/bd_config.php";
require "src/funciones.php";

if (isset($_POST["btnContEditar"])) {
    $error_nombre = $_POST["nombre"] == "";
    $error_usuario = $_POST["usuario"] == "";
    $error_contraseña = $_POST["contraseña"] == "";
    $error_dni = $_POST["dni"] = "" || !bien_escrito_dni($_POST["dni"]) || strtoupper(substr($_POST["dni"], 8, 1)) == LetraNIF(substr($_POST["dni"], 0, 8));
    $error_foto = $_FILES["foto"]["name"] != "" && ($_FILES["foto"]["error"] || !getimagesize($_FILES["foto"]["tmp_name"]) || $_FILES["foto"]["size"] > 50000);

    if (!$error_usuario || !$error_dni) { //Comprobamos si hay repetidos
        try {
            $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
            mysqli_set_charset($conexion, "uft8");
        } catch (Exception $e) {
            die(pag_error("Práctica 8","Práctica 8","Imposible conectar. Error Nº ".mysqli_connect_errno()." : ".mysqli_connect_error()));
        }

        if (!$error_usuario) {
            $error_usuario = repetido($conexion, "usuarios", "usuario", $_POST["usuario"], "id_usuario", $_POST["btnContEditar"]);

            if (is_string($error_usuario)) {
                mysqli_close($conexion);
                die(pag_error("Práctica 8","Práctica 8",$error_usuario));
            }
        }
        if(!$error_dni){
            $error_dni = repetido($conexion, "usuarios","dni",$_POST["dni"],"id_usuario",$_POST["btnContEditar"]);
            if(is_string($error_dni)){
                mysqli_close($conexion);
                die(pag_error("Práctica 8","Práctica 8",$error_dni));
            }
        }
    }


    $error_form_insert = $error_nombre || $error_usuario || $error_contraseña || $error_dni || $error_foto;

    if ($error_form_insert) {
        //CONECTAMOS CON LA BASE DE DATOS:
        try {
            $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {
            die();
        }
        //REALIZAMOS CONSULTA DE INSERCIÓN: 
        $consulta = "INSERT INTO usuarios(nombre, usuario, clave, dni, sexo) VALUES ('" . $_POST["nombre"] . "', '" . $_POST["usuario"] . "', '" . md5($_POST["contraseña"]) . "', '" . strtoupper($_POST["dni"]) . "', '" . $_POST["sexo"] . "')";
        try{
            mysqli_query($conexion, $consulta);
            $mensaje_accion = "Usuario insertado con éxito";
            if($_FILES["foto"]["name"] != ""){
                $ultimo_id=mysqli_insert_id($conexion);
                $arr_nombre = explode(".", $_FILES["foto"]["name"]);
                $extension = "";
                if(count($arr_nombre) > 1){
                    $extension = end($arr_nombre);
                }
                $nuevo_nombre = "img_".$ultimo_id.$extension;

                @$var = move_uploaded_file($_FILES["foto"]["tmp_name"], "img/".$nuevo_nombre);
                if($var){
                    try{
                        $consulta = "UPDATE usuarios SET foto = '".$nuevo_nombre."' WHERE id_usuario = ".$ultimo_id;
                    }catch(Exception $e){
                        mysqli_close($conexion);
                die();
                    }
                }else{
                    $mensaje_accion = "Usuario insertado con éxito con foto por defecto, por no poder mover foto elegida en el servidor";
                }
            }
        }catch(Exception $e){
            mysqli_close($conexion);
                die();
        }
    }
}

if (isset($_POST["btnConfirmarBorrar"])) {
    //CONECTAMOS CON LA BASE DE DATOS:
    try {
        $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        die("Imposible conectar. Error nº: " . mysqli_connect_errno() . ". " . mysqli_connect_error());
    }
    //REALIZAMOS CONSULTA DE BORRADO: 
    $consulta = "DELETE FROM usuarios WHERE id_usuario= '" . $_POST["btnConfirmarBorrar"] . "'";

    try {
        $resultado = mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            height: 150px;
        }
    </style>
    <title>Práctica 8</title>
</head>

<body>
    <h1>Práctica 8</h1>
    <?php
    //1. CONECTAR CON LA BASE DE DATOS:
    try {
        $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);

        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        die("Imposible conectar. Error nº: " . mysqli_connect_errno() . ". " . mysqli_connect_error());
    }

    //3. CONTROLAMOS LAS DISTINTAS OPERACIONES CRUD ------------------------------------------------

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
                echo "<p><strong>DNI: </strong>" . $datos_usuario["dni"] . "</p>";
                echo "<p><strong>Sexo: </strong>" . $datos_usuario["sexo"] . "</p>";
                echo "<img src='img/no_imagen.jpg' alt='Foto de usuario' title='Foto de usuario' class='img_listar'>";
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
        echo "<div class='centrar'>";
        echo "<h3>Borrado del usuario con ID: " . $_POST["btnBorrar"] . "</h3>";
        echo "¿Está seguro?";
        echo "<form action='index.php' method='post'>";
        echo "<p>";
        echo "<button>Volver</button> &nbsp;";
        echo "<button type='submit' name='btnConfirmarBorrar' value='" . $_POST["btnBorrar"] . "'>Borrar</button>";
        echo "</p>";
        echo "</form>";
        echo "</div>";
    } elseif (isset($_POST["btnEditar"])) {
        echo "editamos usuario " . $_POST["btnEditar"];
    } elseif (isset($_POST["btnAgregar"]) || isset($_POST["btnContinuarNuevo"])) {
        echo "<h3>Agregar nuevo usuario</h3>";
    ?>
        <p>
            <label for="nombre">Nombre:</label><br>
            <input type="text" placeholder="Nombre..." id="nombre" name="nombre">
        </p>
        <p>
            <label for="usuario">Usuario:</label><br>
            <input type="text" placeholder="Usuario..." id="usuario" name="usuario">
        </p>
        <p>
            <label for="contraseña">Contraseña:</label><br>
            <input type="password" placeholder="Contraseña..." id="contraseña" name="contraseña">
        </p>
        <p>
            <label for="dni">DNI:</label><br>
            <input type="text" placeholder="11223344K" id="dni" name="dni">
            <?php
            if (isset($_POST["dni"]) && $error_dni) {
                if ($_POST["dni"] == "") {
                    echo "<span class='error'>*Campo vacío*</span>";
                } elseif (!dni_bien_escrito(($_POST["dni"]))) {
                }
            }
            ?>
        </p>
        <p>
            <label>Sexo:</label><br>
            <input type="radio" id="hombre" name="sexo" <?php if (!isset($_POST["sexo"]) || $_POST["sexo"] == "hombre") echo "checked"; ?>><label for="hombre">Hombre</label><br>
            <input type="radio" id="mujer" name="sexo" <?php if (isset($_POST["sexo"]) && $_POST["sexo"] == "mujer") echo "checked"; ?>><label for="mujer">Mujer</label>
        </p>
        <p>
            <label for="foto">Incluir mi foto (máx. 500KB):</label><br>
            <input type="file" id="foto" name="foto" accept="image/*">
            <?php
            if (isset($_POST["btnContinuarNuevo"]) && $error_foto) {
                if ($_FILES["foto"]["error"]) {
                    echo "<span class='error'>*Error en la subida del fichero*</span>";
                } elseif (!getimagesize($_FILES["foto"]["tmp_name"])) {
                    echo "<span class='error'>*El fichero subido no es un archivo imagen*</span>";
                } else {
                    echo "<span class='error'>*El tamaño del fichero supera los 500KB*</span>";
                }
            }
            ?>
        </p>
        <p>
            <button type="submit">Volver</button><br>
            <button type="submit" name="btnContinuarNuevo">Guardar Cambios</button>
        </p>
    <?php
    }

    //------------------------------------------------------------------------------------------------
    //2. CONSULTAR LOS DATOS Y PINTAR LA TABLA.
    try {
        $consulta = "SELECT * FROM usuarios";

        $resultado = mysqli_query($conexion, $consulta);

        echo "<h3 class='centrar'>Listado de usuarios</h3>";
        echo "<table class='txt_centrado centrar'>";
        echo "<tr><th>#</th><th>Foto</th><th>Nombre</th><th><form method='post' action='index.php'><button type='submit' name='btnAgregar' class='enlace'>Usuario+</button></form></th></tr>";
        while ($tupla = mysqli_fetch_assoc($resultado)) {
            echo "<tr>";
            echo "<td>" . $tupla["id_usuario"] . "</td>";
            echo "<td><img src='img/" . $tupla["foto"] . "' title='Foto de perfil' alt='Foto de perfil'></td>";
            echo "<td><form method='post' action='index.php'><button class='enlace' name='btnListar' value='" . $tupla["id_usuario"] . "'>" . $tupla["nombre"] . "</button></form></td>";
            echo "<td><form method='post' action='index.php'><input type='hidden' name='nombre_foto' value='no_imagen.jpg'><button class='enlace' name='btnBorrar' value='" . $tupla["id_usuario"] . "'>Borrar</button>&nbsp;-&nbsp;<button class='enlace' name='btnEditar' value='" . $tupla["id_usuario"] . "'>Editar</button></form></td>";
            echo "</tr>";
        }

        echo "</table>";

        mysqli_free_result($resultado);
        mysqli_close($conexion);
    } catch (Exception $e) {
        $mensaje = "Imposible realizar la consulta. Error nº: " . mysqli_errno($conexion) . ". " . mysqli_error($conexion);
        mysqli_close($conexion);
        die($mensaje);
    }
    ?>

</body>

</html>
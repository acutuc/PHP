<?php
//Si pulsamos Guardar Cambios, en el formulario de registro:
if (isset($_POST["btnBorrar"])) {
    unset($_POST);
}

if (isset($_POST["btnGuardar"])) {
    $error_usuario = $_POST["usuario"] == "";
    //Si hemos escrito algo en el campo usuario:
    if (!$error_usuario) {
        //Comprobamos que dicho usuario no exista en la BD. MIRAR LA FUNCIÓN (devolverá true o false)
        $error_usuario = repetido_reg("usuario", $_POST["usuario"]);
        //Si hemos obtenido un string, es que no hemos podido comprobar con la BD. Destruimos sesiones.
        if (is_string($error_usuario)) {
            session_destroy();
            die(error_page("Práctica Rec 2", "Práctica Rec 2", $error_usuario));
        }
    }
    $error_nombre = $_POST["nombre"] == "";
    $error_clave = $_POST["clave"] == "";
    $error_dni = $_POST["dni"] == "" || !bien_escrito($_POST["dni"]);
    //Hacemos la misma comprobación que el usuario, que no se repita el DNI.
    if (!$error_dni) {
        $error_dni = repetido_reg("dni", strtoupper($_POST["dni"]));
        if (is_string($error_dni)) {
            session_destroy();
            die(error_page("Práctica Rec 2", "Práctica Rec 2", $error_dni));
        }
    }
    $error_imagen = $_FILES["imagen"]["name"] != "" && ($_FILES["imagen"]["error"] || !getimagesize($_FILES["imagen"])["tmp_name"] || $_FILES["imagen"]["size"] > 500000);

    $error_formulario = $error_usuario || $error_nombre || $error_clave || $error_dni;

    //Si no hay error, hacemos el registro del nuevo usuario:
    if (!$error_formulario) {
        //Conectamos con la BD:
        try {
            $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        } catch (PDOException $e) {
            die(error_page("Práctica Rec 2", "Práctica Rec 2", "Imposible conectar. Error: " . $e->getMessage()));
        }
        //Insertamos primero mirando si hay foto en el registro:
        try {
            $consulta = "INSERT INTO usuarios(usuario, clave, nombre, dni, sexo, subscripcion) VALUES(?, ?, ?, ?, ?, ?)";
            $sentencia = $conexion->prepare($consulta);
            //Comprobamos si el usuario está suscrito o no:
            $subs = 0;
            if (isset($_POST["suscripcion"])) {
                $subs = 1;
            }

            $datos[] = $_POST["usuario"];
            $datos[] = md5($_POST["clave"]);
            $datos[] = $_POST["nombre"];
            $datos[] = $_POST["dni"];
            $datos[] = $_POST["sexo"];
            $datos[] = $subs;

            $sentencia->execute($datos);

        } catch (PDOException $e) {
            $sentencia = null;
            $conexion = null;
            session_destroy();
            die(error_page("Práctica Rec 2", "Práctica Rec 2", "Imposible conectar. Error: " . $e->getMessage()));
        }
        $mensaje = "¡Has sido registrado con éxito!";
        //Ahora tratamos la imagen.
        //Si hemos seleccionado una imagen:
        if ($_FILES["foto"]["name"] != "") {
            //Cogemos el último id insertado:
            $ultimo_id = $conexion->lastInsertId();
            $array_extension = explode(".", $_FILES["foto"]["name"]);
            $ext = "";
            //Si tiene formato:
            if (count($array_extension) > 0) {
                //Asignamos el formato a la extensión:
                $ext = "." . end($array_extension);
            }
            //Asignamos el nombre completo al archivo (img_5.jpg, por ejemplo):
            $nombre_nuevo_img = "img_" . $ultimo_id . $ext;
            //Movemos el archivo:
            @$var = move_uploaded_file($_FILES["foto"]["tmp_name"], "images/" . $nombre_nuevo_img);
            //Si hemos podido mover el archivo:
            if ($var) {
                //Actualizamos el usuario en la BD:
                try {
                    $consulta = "UPDATE usuarios SET foto = ? WHERE id_usuario = ?";
                    $sentencia = $conexion->prepare($consulta);

                    $datos[] = $nombre_nuevo_img;
                    $datos[] = $ultimo_id;

                    $sentencia->execute($datos);

                } catch (PDOException $e) {
                    //Si ha fallado, borramos la imagen:
                    unlink("images/" . $nombre_nuevo_img);
                }
                $sentencia = null;
            } else {
                $mensaje = "Has sido registrado con la imagen por defecto.";
            }
        }
        $_SESSION["usuario"] = $datos[0];
        $_SESSION["clave"] = $datos[1];
        $_SESSION["ultimo_acceso"] = time();
        $_SESSION["bienvenida"] = $mensaje;
        $conexion = null;
        header("Location:index.php");
        exit();
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
        .botones {
            display: flex;
            justify-content: space-around;
            width: 400px;
        }

        .error {
            color: red;
        }
    </style>
    <title>Práctica Rec2</title>
</head>

<body>
    <h1>Práctica Rec 2</h1>
    <form action="index.php" method="post">
        <p>
            <label for="usuario">Usuario: </label><input type="text" name="usuario" id="usuario"
                placeholder="Usuario..." value="<?php if (isset($_POST["usuario"]))
                    echo $_POST["usuario"] ?>">
                <?php
                if (isset($_POST["btnGuardar"]) && $error_usuario) {
                    if ($_POST["usuario"] == "") {
                        echo "<span class='error'>*Campo vacío*</span>";
                    } else {
                        echo "<span class='error'>*Usuario ya se encuentra registrado*</span>";
                    }
                }
                ?>
        </p>
        <p>
            <label for="nombre">Nombre: </label><input type="text" name="nombre" id="nombre" placeholder="Nombre..."
                value="<?php if (isset($_POST["nombre"]))
                    echo $_POST["nombre"]; ?>">
            <?php
            if (isset($_POST["btnGuardar"]) && $error_nombre) {
                echo "<span class='error'>*Campo vacío*</span>";
            }
            ?>
        </p>
        <p>
            <label for="clave">Contraseña: </label><input type="password" name="clave" id="clave"
                placeholder="Contraseña...">
            <?php
            if (isset($_POST["btnGuardar"]) && $error_clave) {
                echo "<span class='error'>*Campo vacío*</span>";
            }
            ?>
        </p>
        <p>
            <label for="dni">DNI: </label><input type="text" name="dni" id="dni" placeholder="DNI: 11223344Z" value="<?php if (isset($_POST["dni"]))
                echo $_POST["dni"]; ?>">
            <?php
            if (isset($_POST["btnGuardar"]) && $error_dni) {
                if ($_POST["dni"] == "") {
                    echo "<span class='error'>*Campo vacío*</span>";
                } else if (!bien_escrito($_POST["dni"])) {
                    echo "<span class='error'>*Formato no válido*</span>";
                } else {
                    echo "<span class='error'>*DNI ya se encuentra registrado*</span>";
                }
            }
            ?>
        </p>
        <p>
            Sexo: <br>
            <input type="radio" name="sexo" id="hombre" value="hombre" checked> <label for="hombre">Hombre</label><br>
            <input type="radio" name="sexo" id="mujer" value="mujer" <?php if (isset($_POST["sexo"]) && $_POST["sexo"] == "mujer")
                echo "checked"; ?>> <label for="mujer">Mujer</label>
        </p>
        <p>
            <label for="imagen">Incluir mi foto (Máx. 500KB) </label><input type="file" accept="image/*" name="imagen"
                id="imagen">
        </p>
        <p>
            <input type="checkbox" id="suscripcion" value="suscripcion" name="suscripcion"> <label
                for="suscripcion">Suscribirme al boletín de novedades</label>
        </p>
        <p class="botones">
            <button type="submit" name="btnGuardar">Guardar Cambios</button> <button type="submit"
                name="btnBorrar">Borrar los datos introducidos</button>
        </p>
    </form>
</body>

</html>
<?php
session_name("examen3_22_23");
session_start();

require "src/bd_config.php";

// SERVIDOR_BD,USUARIO_BD,CLAVE_BD y NOMBRE_BD son CTES


//Algunas funciones y metodos según conexion PDO ó mysqli
//$ultim_id=$conexion->lastInsertId();

//$ultim_id=mysqli_insert_id($conexion);

function error_page($titulo, $cabecera, $cuerpo)
{
    '<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>' . $titulo . '</title>
    </head>
    <body>
        <h1>' . $cabecera . '</h1>
        ' . $cuerpo . '
    </body>
    </html>';
}

//Si no existe $_SESSION, o existe el btnSalir, no nos hemos logueado:
if (!isset($_SESSION["usuario"]) || isset($_POST["btnSalir"])) {
    //Si hemos pulsado Salir, destruimos sesión:
    if (isset($_POST["btnSalir"])) {
        session_destroy();
    }
    //Si hemos pulsado el botón entrar en el login:
    if (isset($_POST["btnEntrar"])) {
        $error_usuario = $_POST["usuario"] == "";
        $error_clave = $_POST["clave"] == "";

        $error_formulario = $error_usuario || $error_clave;

        if (!$error_formulario) {
            //Conectamos con la BD:
            try {
                $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
            } catch (PDOException $e) {
                die(error_page("Videoclub", "Videoclub", "Imposible conectar. Error: " . $e->getMessage()));
            }

            //Hacemos la consulta:
            try {
                $consulta = "SELECT * FROM clientes WHERE usuario = ? AND clave = ?";

                //Preparamos la consulta:
                $sentencia = $conexion->prepare($consulta);

                $datos[] = $_POST["usuario"];
                $datos[] = md5($_POST["clave"]);

                //Ejecutamos la sentencia:
                $sentencia->execute($datos);

                //Si hemos obtenido tuplas, logeamos e iniciamos las sesiones.
                if ($sentencia->rowCount() > 0) {
                    $_SESSION["usuario"] = $datos[0];
                    $_SESSION["clave"] = $datos[1];
                    $_SESSION["ultimo_acceso"] = time();

                    header("Location:index.php");
                    exit();
                } else {
                    //Si no, el usuario no existe:
                    $error_usuario = true;
                }
            } catch (PDOException $e) {
                die(error_page("Videoclub", "Videoclub", "Imposible conectar. Error: " . $e->getMessage()));
            }
        }
    }
    //Para poder registrarnos, se tiene que haber pulsado Registrarse o Continuar para el formulario de registro:
    if (isset($_POST["btnRegistrarse"]) || isset($_POST["btnContinuar"])) {
        //Si dentro del formulario pulsamos en continuar, comprobamos errores:
        if (isset($_POST["btnContinuar"])) {
            $error_nuevo_usuario = $_POST["nuevoUsuario"] == "";
            //Habrá error en claves cuando, o estén vacías, o no sean iguales:
            $error_nueva_clave = $_POST["nuevaClave"] == "" || ($_POST["nuevaClave"] != $_POST["nuevaClave2"]);
            $error_nueva_clave_2 = $_POST["nuevaClave2"] == "" || ($_POST["nuevaClave2"] != $_POST["nuevaClave"]);
            //$error_foto = $_FILES["foto"]["name"] != "" && ($_FILES["foto"]["error"] || !getimagesize($_FILES["foto"]["tmp_name"] || $_FILES["foto"]["size"] > 500000));

            $error_form = $error_nuevo_usuario || $error_nueva_clave || $error_nueva_clave_2; //|| $error_foto;

            //Si no hay error en el formulario, accedemos a la BD.
            if (!$error_form) {
                //Abrimos conexion:
                try {
                    $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
                } catch (PDOException $e) {
                    die(error_page("Videoclub", "Videoclub", "Imposible conectar. Error: " . $e->getMessage()));
                }

                //Hacemos la consulta y comprobamos si no hay duplicado en la BD:
                try {
                    $consulta = "SELECT * FROM clientes WHERE usuario = ? AND clave = ?";

                    //Preparamos la sentencia:
                    $sentencia = $conexion->prepare($consulta);

                    $datos[] = $_POST["nuevoUsuario"];
                    $datos[] = md5($_POST["nuevaClave"]);

                    //Ejecutamos la sentencia:
                    $sentencia->execute($datos);

                    //Si NO obtenemos tuplas, podemos registrarnos y loguearnos:
                    if ($sentencia->rowCount() < 1) {
                        //Hacemos nueva consulta de inserción a la BD:
                        try {
                            //Utilizamos las mismas variables para machacar:
                            $consulta = "INSERT INTO clientes (usuario, clave) VALUES (?, ?)";

                            //Preparamos la sentencia:
                            $sentencia = $conexion->prepare($consulta);

                            //Utilizamos los mismos datos de $datos y ejecutamos
                            $sentencia->execute($datos);

                            //Creamos las sesiones con el nuevo usuario para loguearnos:
                            $_SESSION["usuario"] = $datos[0];
                            $_SESSION["clave"] = $datos[1];
                            $_SESSION["ultimo_acceso"] = time();

                            //y volvemos al header:
                            header("Location:index.php");
                            exit();

                        } catch (PDOException $e) {
                            $sentencia = null;
                            $conexion = null;
                            die(error_page("Videoclub", "Videoclub", "Imposible conectar. Error: " . $e->getMessage()));
                        }
                    } else {
                        //Si obtenemos tuplas, hay un usuario ya registrado con ese nick:
                        $error_nuevo_usuario = true;
                    }
                } catch (PDOException $e) {
                    $sentencia = null;
                    $conexion = null;
                    die(error_page("Videoclub", "Videoclub", "Imposible conectar. Error: " . $e->getMessage()));
                }
            }
        }
        ?>
        <!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Videoclub</title>
        </head>

        <body>
            <h1>Videoclub</h1>
            <form action="index.php" method="post" enctype="multipart/form-data">
                <p>
                    <label for="nuevoUsuario">Nombre de usuario: </label>
                    <input type="text" id="nuevoUsuario" name="nuevoUsuario" value="<?php if (isset($_POST["nuevoUsuario"]))
                        echo $_POST["nuevoUsuario"] ?>">
                        <?php
                    if (isset($_POST["btnContinuar"]) && $error_nuevo_usuario) {
                        if ($_POST["nuevoUsuario"] == "") {
                            echo "<span class='error'>*Campo vacío*</span>";
                        } else {
                            echo "<span class='error'>*El usuario ya se encuentra registrado*</span>";
                        }
                    }
                    ?>
                </p>
                <p>
                    <label for="nuevaClave">Contraseña: </label>
                    <input type="password" id="nuevaClave" name="nuevaClave">
                    <?php
                    if (isset($_POST["btnContinuar"]) && $error_nueva_clave) {
                        if ($_POST["nuevaClave"] == "") {
                            echo "<span class='error'>*Campo vacío*</span>";
                        } else {
                            echo "<span class='error'>*Las claves no coinciden*</span>";
                        }
                    }
                    ?>
                </p>
                <p>
                    <label for="nuevaClave2">Repita la contraseña</label>
                    <input type="password" id="nuevaClave2" name="nuevaClave2">
                    <?php
                    if (isset($_POST["btnContinuar"]) && $error_nueva_clave_2) {
                        if ($_POST["nuevaClave2"] == "") {
                            echo "<span class='error'>*Campo vacío*</span>";
                        } else {
                            echo "<span class='error'>*Las claves no coinciden*</span>";
                        }
                    }
                    ?>
                </p>
                <p>
                    <label for="foto">Foto: </label>
                    <input type="file" name="foto" id="foto" accept="images/*">
                </p>
                <p>
                    <button type="submit">Volver</button>
                    <button type="submit" name="btnContinuar">Continuar</button>
                </p>
            </form>
        </body>

        </html>
        <?php
    } else {
        ?>
        <!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Videoclub</title>
        </head>

        <body>
            <h1>Videoclub</h1>
            <form action="index.php" method="post">
                <p>
                    <label for="usuario">Nombre de usuario: </label>
                    <input type="text" name="usuario" id="usuario" value="<?php if (isset($_POST["usuario"]))
                        echo $_POST["usuario"] ?>">
                        <?php
                    if (isset($_POST["btnEntrar"]) && $error_usuario) {
                        if ($_POST["usuario"] == "") {
                            echo "<span class='error'>*Campo vacío*</span>";
                        }
                    }
                    ?>
                </p>
                <p>
                    <label for="clave">Contraseña: </label>
                    <input type="password" name="clave" id="clave">
                    <?php
                    if (isset($_POST["btnEntrar"]) && $error_clave) {
                        echo "<span class='error'>*Campo vacío*</span>";
                    }
                    ?>
                </p>
                <p>
                    <?php
                    if (isset($_POST["btnEntrar"]) && $error_usuario) {
                        if ($_POST["usuario"] != "") {
                            echo "<span class='error'>*Usuario o contraseña incorrectos.*</span>";
                        }
                    }
                    ?>
                </p>
                <p>
                    <button type="submit" name="btnEntrar">Entrar</button>
                    <button type="submit" name="btnRegistrarse">Registrarse</button>
                </p>
            </form>
        </body>

        </html>
        <?php
    }
} else {
    //ELSE para cuando haya $_SESSION:

    //Realizamos conexion:
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        die(error_page("Videoclub", "Videoclub", "Imposible conectar. Error: " . $e->getMessage()));
    }

    //Miramos que tipo de usuario es el que está logueado:
    try {
        $consulta = "SELECT * FROM clientes WHERE usuario = ?";

        $sentencia = $conexion->prepare($consulta);

        $sentencia->execute([$_SESSION["usuario"]]);

        $respuesta = $sentencia->fetchAll(PDO::FETCH_ASSOC);

        //Recorremos toda la variable $respuesta para almacenar los datos en el array $tupla;
        foreach ($respuesta as $tupla);

    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        die(error_page("Videoclub", "Videoclub", "Imposible conectar. Error: " . $e->getMessage()));
    }

    //SI SOMOS ADMIN:
    if ($tupla["tipo"] == "admin") {
        require "admin/gest_clientes.php";
    } else {
        //Si somos usuario normal:
        require "vista_normal.php";
    }
}
?>
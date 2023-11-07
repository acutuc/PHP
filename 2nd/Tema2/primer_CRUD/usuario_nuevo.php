<?php
//Funciones error_page y repetido:
function error_page($title, $body)
{
    $page = '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>' . $title . '</title>
    </head>
    <body>' . $body . '</body>
    </html>';
    return $page;
}

function repetido($conexion, $tabla, $columna, $valor)
{

    try {
        $consulta = "SELECT * FROM " . $tabla . " WHERE " . $columna . "='" . $valor . "'";
        $resultado = mysqli_query($conexion, $consulta);
        $respuesta = mysqli_num_rows($resultado) > 0;
        mysqli_free_result($resultado);
    } catch (Exception $e) {
        mysqli_close($conexion);
        $respuesta = error_page("Práctica 1º CRUD", "<h1>Práctica 1º CRUD</h1><p>No se ha podido hacer la consulta: " . $e->getMessage() . "</p>");
    }
    return $respuesta;
}

if (isset($_POST["btnNuevoUsuario"]) || isset($_POST["btnContinuar"])) {

    if (isset($_POST["btnContinuar"])) {
        $error_nombre = $_POST["nombre"] == "" || strlen($_POST["nombre"] > 30);
        $error_usuario = $_POST["usuario"] == "" || strlen($_POST["usuario"] > 20);

        //Verificamos que el usuario no exista en la BD:
        if (!$error_usuario) {
            //Nos conectamos a la BD para poder recoger los datos:
            try {
                $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_foro");
                mysqli_set_charset($conexion, "utf8");
            } catch (Exception $e) {
                die(error_page("Práctica 1º CRUD", "<h1>Práctica 1º CRUD</h1><p>No he podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
            }

            $error_usuario = repetido($conexion, "usuarios", "usuario", $_POST["usuario"]);

            if (is_string($error_usuario)) {
                die($error_usuario);
            }
        }

        $error_clave = $_POST["clave"] == "" || strlen($_POST["clave"] > 15);
        $error_email = $_POST["email"] == "" || strlen($_POST["email"]) > 50 || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);

        //Verificamos que el email no exista en la BD:
            if (!$error_email) {
                if (!isset($conexion)) {
                    try {
                        $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_foro");
                        mysqli_set_charset($conexion, "utf8");
                    } catch (Exception $e) {
                        die(error_page("Práctica 1º CRUD", "<h1>Práctica 1º CRUD</h1><p>No he podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
                    }
                }
                $error_email = repetido($conexion, "usuarios", "email", $_POST["email"]);
    
                if (is_string($error_email)) {
                    die($error_email);
                }
            }

        $error_form = $error_nombre || $error_usuario || $error_clave || $error_email;

        //Si no hay error en el formulario, insertamos:
        if (!$error_form) {
            //Conexión a la BD.
            try {
                $consulta="INSERT INTO usuarios (nombre,usuario,clave,email) values ('".$_POST["nombre"]."','".$_POST["usuario"]."','".md5($_POST["clave"])."','".$_POST["email"]."')";
                mysqli_query($conexion, $consulta);
            } catch (Exception $e) {
                mysqli_close($conexion);
                die(error_page("Práctica 1º CRUD","<h1>Práctica 1º CRUD</h1><p>No se ha podido hacer la consulta: ".$e->getMessage()."</p>"));
            }
            mysqli_close($conexion);

            header("Location:index.php");
            exit;
        }

        //Por aquí continuo sólo si hay errores en el formulario
        if(isset($conexion))
        {
            mysqli_close($conexion);
        }
    }
    }
?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Nuevo usuario</title>
        <style>
            .error {
                color: red;
            }
        </style>
    </head>

    <body>
        <h1>Nuevo usuario</h1>
        <form method="post" action="usuario_nuevo.php">
            <p>
                <label for="nombre">Nombre: </label><input type="text" name="nombre" maxlength="30" id="nombre" value="<?php if (isset($_POST["nombre"])) echo $_POST["nombre"] ?>">
                <?php
                if (isset($_POST["btnContinuar"]) && $error_nombre) {
                    echo "<span class='error'>* Campo vacío *</span>";
                }
                ?>
            </p>
            <p>
                <label for="usuario">Usuario: </label><input type="text" name="usuario" maxlength="20" id="usuario" value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"] ?>">
                <?php
                if (isset($_POST["btnContinuar"]) && $error_usuario) {
                    echo "<span class='error'>* Campo vacío *</span>";
                }
                ?>
            </p>
            <p>
                <label for="clave">Contraseña: </label><input type="password" name="clave" maxlength="15" id="clave">
                <?php
                if (isset($_POST["btnContinuar"]) && $error_clave) {
                    echo "<span class='error'>* Campo vacío *</span>";
                }
                ?>
            </p>
            <p>
                <label for="email">Email: </label><input type="text" name="email" maxlength="50" id="email" value="<?php if (isset($_POST["email"])) echo $_POST["email"] ?>">
                <?php
                if (isset($_POST["btnContinuar"]) && $error_email) {
                    echo "<span class='error'>* Campo vacío *</span>";
                }
                ?>
            </p>
            <p>
                <button name="btnContinuar">Continuar</button> <button>Volver</button>
            </p>
        </form>
    </body>

    </html>
<?php
} else {
    header("Location:index.php");
    exit();
}
?>
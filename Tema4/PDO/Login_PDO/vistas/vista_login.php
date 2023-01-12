<?php
if (isset($_POST["btnLogin"])) {
    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";

    $error_formulario = $error_usuario || $error_clave;

    if (!$error_formulario) {
        //Conectamos a la BD:
        try {
            $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        } catch (PDOException $e) {
            die(error_page("Login PDO", "Login con PDO", "<p>Imposible conectar. Error: " . $e->getMessage() . "</p></body></html>"));
        }

        //Consulta:
        try {
            $consulta = "SELECT * FROM usuarios WHERE usuario = ? AND clave = ?";

            $sentencia = $conexion->prepare($consulta);
            $datos[] = $_POST["usuario"];
            $datos[] = md5($_POST["clave"]);
            $sentencia->execute($datos);

            if ($sentencia->rowCount() > 0) { //Si hay tuplas (se ha loggeado):
                //Si existe el usuario, creamos la sesión con los datos del usuario (lo ponemos arriba):

                $_SESSION["usuario"] = $datos[0];
                $_SESSION["clave"] = $datos[1];
                $_SESSION["ultimo_acceso"] = time();
                header("Location:index.php");
                exit();
            } else {
                $error_usuario = true;
            }
        } catch (PDOException $e) {
            $sentencia = null; //Libera sentencia
            $conexion = null; //Cierra conexión
            die(error_page("Login PDO", "Login con PDO", "<p>Imposible conectar. Error: " . $e->getMessage() . "</p></body></html>"));
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
    <title>Login PDO</title>
</head>

<body>
    <h1>Login PDO</h1>
    <?php
    //Si hemos sido baneados (eliminados de la BD):
    if (isset($_SESSION["seguridad"])) {
        echo "<p class='mensaje'>" . $_SESSION["seguridad"] . "</p>";

        //Eliminamos la variable $_SESSION["seguridad"]:
        unset($_SESSION["seguridad"]);
    }
    ?>
    <form action="index.php" method="post">
        <p>
            <label for="usuario">Usuario: </label>
            <input type="text" name="usuario" id="usuario" value="<?php if (isset($_POST["usuario"]))
                echo $_POST["usuario"] ?>">
            <?php
            if (isset($_POST["usuario"]) && $error_usuario) {
                if ($_POST["usuario"] == "") {
                    echo "<span class='error'>*Campo vacío*</span>";
                } else {
                    echo "<span class='error'>*Usuario no existe*</span>";
                }

            }
            ?>
        </p>
        <p>
            <label for="clave">Contraseña: </label>
            <input type="password" name="clave" id="clave">
            <?php
            if (isset($_POST["clave"]) && $error_clave) {
                echo "<span class='error'>*Campo vacío*</span>";
            }
            ?>
        </p>
        <p>
            <button type="submit" name="btnLogin" value="Login">Login</button>
        </p>
    </form>
</body>

</html>
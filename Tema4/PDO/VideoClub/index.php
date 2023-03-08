<?php
session_name("VideoclubExam");
session_start();

require "src/bd_config.php";

if (isset($_POST["btnEntrar"])) {
    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";

    $error_formulario = $error_usuario || $error_clave;

    if (!$error_formulario) {
        //Conectamos con la BD:
        try {
            $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        } catch (PDOException $e) {
            die("Imposible conectar. Error: " . $e->getMessage());
        }

        //Hacemos la consulta:
        try {
            $consulta = "SELECT * FROM clientes WHERE usuario = ? AND clave = ?";

            //Preparamos la sentencia:
            $sentencia = $conexion->prepare($consulta);

            $datos[] = $_POST["usuario"];
            $datos[] = md5($_POST["clave"]);

            //Ejecutamos la sentencia:
            $sentencia->execute($datos);

            if ($sentencia->rowCount() > 0) {
                $_SESSION["usuario"] = $datos[0];
                $_SESSION["clave"] = $datos[1];
                $_SESSION["ultimo_acceso"] = time();
            }
        } catch (PDOException $e) {
            die("Imposible conectar. Error: " . $e->getMessage());
        }
    }
}

if (isset($_POST["btnRegistrarse"])) {

    if(isset($_POST["btnContinuar"])){
        $error_nuevoUsuario = $_POST["nuevoUsuario"] == "";
        $error_
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
                <input type="text" id="nuevoUsuario" name="nuevoUsuario"
                    value="<?php if (isset($_POST["nuevoUsuario"]))
                        echo $_POST["nuevoUsuario"] ?>">
                </p>
                <p>
                    <label for="nuevaClave">Contraseña: </label>
                    <input type="text" id="nuevaClave" name="nuevaClave">
                </p>
                <p>
                    <label for="nuevaClave2">Repita la contraseña: </label>
                    <input type="text" id="nuevaClave2" name="nuevaClave2">
                </p>
                <p>
                    <label for="foto">Foto: </label>
                    <input type="file" id="foto" name="foto" accept="image/*">
                </p>
                <p>
                    <button type="submit" formaction="index.php">Volver</button>
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
                <input type="text" name="usuario" value="<?php if (isset($_POST["usuario"]))
                    echo $_POST["usuario"]; ?>" id="usuario">
                <?php
                if (isset($_POST["btnEntrar"]) && $error_usuario) {
                    echo "<span class='error'>*Campo vacío*</span>";
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
                <button type="submit" name="btnEntrar">Entrar</button>
                <button type="submit" name="btnRegistrarse">Registrarse</button>
            </p>
        </form>
    </body>

    </html>
    <?php
}
?>
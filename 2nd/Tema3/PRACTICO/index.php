<?php
session_name("practico");
session_start();
if (isset($_POST["btnEntrar"])) {
    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";

    $error_form = $error_usuario || $error_clave;

    if (!$error_form) {
        try {
            $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_videoclub");
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {
            die("no se puede conectar");
        }

        try {
            $consulta = "SELECT * FROM usuarios WHERE usuario = '" . $_POST["usuario"] . "' AND clave = '" . md5($_POST["clave"])."'";
            $resultado = mysqli_query($conexion, $consulta);
        } catch (Exception $e) {
            mysqli_close($conexion);
            die("AQUI TAMPOCO ENTRAMOS ".$e->getMessage());
        }

        if (mysqli_num_rows($resultado) > 0) {
            $_SESSION["usuario"] = $_POST["usuario"];
            $_SESSION["clave"] = md5($_POST["usuario"]);
            $_SESSION["ultima_accion"] = time();
            $datos_usu_log = mysqli_fetch_assoc($resultado);
            $_SESSION["DNI"] = $datos_usu_log["DNI"];
            $_SESSION["telefono"] = $datos_usu_log["telefono"];
            $_SESSION["email"] = $datos_usu_log["email"];
            header("Location:entro.php");
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Club</title>
</head>

<body>
    <h1>Video Club</h1>
    <form action="index.php" method="post">
        <p>
            <label for="usuario">Nombre de usuario: </label><input type="text" name="usuario" id="usuario" value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"] ?>">
        </p>
        <p>
            <label for="clave">Contraseña: </label><input type="password" name="clave" id="clave">
        </p>
        <p>
            <button name="btnEntrar">Entrar</button>
        </p>
    </form>
</body>

</html>
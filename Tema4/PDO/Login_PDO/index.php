<?php
session_name("Login_PDO");
session_start();

require "src/config_bd.php";
function error_page($title, $encabezado, $mensaje)
{
    return '<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>' . $title . '</title>
    </head>
    <body>
        <h1>' . $encabezado . '</h1>
        ' . $mensaje . '
    </body>
    </html>';
}

//Si pulsamos en Salir en vista_normal:
if (isset($_POST["btnSalir"])) {
    session_destroy();
    header("Location:index.php");
    exit;
}

//Si hay $_SESSION:
if (isset($_SESSION["usuario"]) && isset($_SESSION["clave"]) && isset($_SESSION["ultimo_acceso"])) {

    require "src/seguridad.php";

    if ($datos_usuario_log["tipo"] == "admin") { //Si somos admin:
        require "vistas/vista_admin.php";
    } else { //Si somos usuario normal:
        require "vistas/vista_normal.php";
    }

    $conexion = null;
} else {
    require "vistas/vista_login.php";
}
<?php
require "bd_config.php";
function consumir_servicios_rest($url, $metodo, $datos = null)
{
    $llamada = curl_init();
    curl_setopt($llamada, CURLOPT_URL, $url);
    curl_setopt($llamada, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($llamada, CURLOPT_CUSTOMREQUEST, $metodo);
    if (isset($datos)) {
        curl_setopt($llamada, CURLOPT_POSTFIELDS, http_build_query($datos));
    }
    $respuesta = curl_exec($llamada);
    curl_close($llamada);
    return $respuesta;
}
function login($datos)
{
    try {
        $conexion = $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {
            $consulta = "SELECT * FROM usuarios WHERE usuario = ? AND clave = ?";

            $sentencia = $conexion->prepare($consulta);

            //Los datos los recojo de getParam()!!!
            $sentencia->execute($datos);

            if ($sentencia->rowCount() > 0) {
                //Devolvemos los datos del usuario:
                $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
            } else {
                $respuesta["mensaje"] = "Usuario no se encuentra en la BD";
            }

            $sentencia = null;
            $conexion = null;
        } catch (PDOException $e) {
            $respuesta["mensaje_error"] = "No se ha podido realizar la consulta. Error: " . $e->getMessage();
        }
    } catch (PDOException $e) {
        $respuesta["mensaje_error"] = "Imposible conectar. Error: " . $e->getMessage();
    }
    return $respuesta;
}

function obtener_usuarios()
{
    try {
        $conexion = $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {
            $consulta = "SELECT * FROM usuarios WHERE tipo = 'normal'";

            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute();

            if ($sentencia->rowCount() > 0) {
                //Devolvemos los datos del usuario:
                $respuesta["usuarios"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $respuesta["mensaje"] = "No hay usuarios de tipo \"normal\" en la BD";
            }

            $sentencia = null;
            $conexion = null;
        } catch (PDOException $e) {
            $respuesta["mensaje_error"] = "No se ha podido realizar la consulta. Error: " . $e->getMessage();
        }
    } catch (PDOException $e) {
        $respuesta["mensaje_error"] = "Imposible conectar. Error: " . $e->getMessage();
    }
    return $respuesta;
}

function error_page($title, $cabecera, $mensaje)
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
        <h1>' . $cabecera . '</h1><p>' . $mensaje . '</p>
    </body>
    </html>';
}

define("DIR_SERV", "http://localhost/PHP/Recuperacion/Pract3/servicios_rest")
    ?>
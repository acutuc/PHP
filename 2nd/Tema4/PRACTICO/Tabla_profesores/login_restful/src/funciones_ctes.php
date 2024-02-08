<?php

define('SERVIDOR_BD', 'localhost');
define('USUARIO_BD', 'jose');
define('CLAVE_BD', 'josefa');
define('NOMBRE_BD', 'bd_horarios_exam');

function login($usuario, $clave)
{
    //Conexión
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        return array("error" => "No ha podido conectarse a la base de batos: " . $e->getMessage());
    }

    //Consulta
    try {
        $consulta = "SELECT * FROM usuarios WHERE usuario = ? AND clave = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$usuario, $clave]);
    } catch (PDOException $e) {
        $conexion = null;
        $sentencia = null;
        return array("error" => "No ha podido conectarse a la base de batos: " . $e->getMessage());
    }

    //Comprobamos si hemos obtenido tuplas:
    if ($sentencia->rowCount() > 0) {
        //Iniciamos las sesiones:
        session_name("sesion_de_la_api");
        session_start();

        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
        $respuesta["api_session"] = session_id();

        $_SESSION["usuario"] = $respuesta["usuario"]["usuario"];
        $_SESSION["clave"] = $respuesta["usuario"]["clave"];
        $_SESSION["tipo"] = $respuesta["usuario"]["tipo"];
    } else {
        $respuesta["mensaje"] = "El usuario o contraseña no existen en la BD.";
    }
    $conexion = null;
    $sentencia = null;
    return $respuesta;
}

function logueado($usuario, $clave)
{
    //Conexión
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        return array("error" => "No ha podido conectarse a la base de batos: " . $e->getMessage());
    }

    //Consulta
    try {
        $consulta = "SELECT * FROM usuarios WHERE usuario = ? AND clave = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$usuario, $clave]);
    } catch (PDOException $e) {
        $conexion = null;
        $sentencia = null;
        return array("error" => "No ha podido conectarse a la base de batos: " . $e->getMessage());
    }

    if ($sentencia->rowCount() > 0) {
        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
    } else {
        $respuesta["mensaje"] = "El usuario o contraseña no existen en la BD.";
    }
    $conexion = null;
    $sentencia = null;
    return $respuesta;
}

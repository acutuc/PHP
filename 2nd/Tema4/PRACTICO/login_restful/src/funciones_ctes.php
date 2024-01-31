<?php

define('SERVIDOR_BD', 'localhost');
define('USUARIO_BD', 'jose');
define('CLAVE_BD', 'josefa');
define('NOMBRE_BD', 'bd_tienda');

function login($usuario, $clave)
{
    //conexión PDO
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        return array("error" => "No ha podido conectarse a la base de batos: " . $e->getMessage());
    }

    try {
        $consulta = "SELECT * FROM usuarios WHERE usuario = ? AND clave = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$usuario, $clave]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        return array("error" => "Error en la consulta: " . $e->getMessage());
    }

    if($sentencia->rowCount() > 0){
        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
    }else{
        $respuesta["mensaje"] = "El usuario o contraseña no existen";
    }
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

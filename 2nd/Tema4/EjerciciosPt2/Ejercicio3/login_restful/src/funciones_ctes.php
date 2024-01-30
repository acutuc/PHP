<?php

define('SERVIDOR_BD', 'localhost');
define('USUARIO_BD', 'jose');
define('CLAVE_BD', 'josefa');
define('NOMBRE_BD', 'bd_foro');


// a)
function obtener_usuarios()
{
    //conexión PDO
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        return array("error" => "No ha podido conectarse a la base de batos: " . $e->getMessage());
    }

    //consulta PDO
    try {
        $consulta = "SELECT * FROM usuarios";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        return array("error" => "No se ha podido realizar la consulta: " . $e->getMessage());
    }
    $respuesta["usuarios"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

// b)
function crear_usuario($datos)
{

    //conexión PDO
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        return array("error" => "No ha podido conectarse a la base de batos: " . $e->getMessage());
    }

    //consulta PDO
    try {
        $consulta = "INSERT INTO usuarios (nombre, usuario, clave, email) VALUES (?, ?, ?, ?)";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        return array("error" => "No se ha podido realizar la consulta: " . $e->getMessage());
    }

    //respuesta PDO
    $respuesta["ult_id"] = $conexion->lastInsertId();

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

// c)
function login($usuario, $clave)
{

    //conexión PDO
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        return array("error" => "No ha podido conectarse a la base de batos: " . $e->getMessage());
    }

    //consulta PDO
    try {
        $consulta = "SELECT * FROM usuarios WHERE usuario = ? AND clave = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$usuario, $clave]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        return array("error" => "No se ha podido realizar la consulta: " . $e->getMessage());
    }

    //respuesta PDO
    if ($sentencia->rowCount() > 0) {
        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
    } else {
        $respuesta["mensaje"] = "El usuario no se encuentra en la BD";
    }
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

// d)
function actualizar_usuario($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        return array("error" => "No ha podido conectarse a la base de batos: " . $e->getMessage());
    }

    try {
        $consulta = "UPDATE usuarios SET nombre = ?, usuario = ?, clave = ?, email = ?, WHERE id_usuario = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        return array("error" => "No se ha podido realizar la consulta: " . $e->getMessage());
    }

    if ($sentencia->rowCount() > 0) {
        $respuesta["mensaje"] = "El usuario con id: " . $datos[4] . " se ha actualizado con éxito";
    } else {
        $respuesta["error"] = "El usuario con id: " . $datos[4] . " no se encuentra en la BD";
    }

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

// e)
function borrar_usuario($id_usuario)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        return array("error" => "No ha podido conectarse a la base de batos: " . $e->getMessage());
    }

    try {
        $consulta = "DELETE FROM usuarios WHERE id_usuario = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$id_usuario]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        return array("error" => "No se ha podido realizar la consulta: " . $e->getMessage());
    }

    $respuesta["mensaje"] = "El usuario con id: " . $id_usuario . " se ha eliminado de la BD";

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

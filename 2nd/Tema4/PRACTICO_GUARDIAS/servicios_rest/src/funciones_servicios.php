<?php
require "config_bd.php";

function login($usuario, $clave)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
    }
    try {
        $consulta = "SELECT * FROM usuarios WHERE usuario = ? AND clave = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$usuario, $clave]);
    } catch (PDOException $e) {
        $respuesta["error"] = "Error en la consulta: " . $e->getMessage();
    }

    if ($sentencia->rowCount() > 0) {
        session_name("api_exam_sw_23_24");
        session_start();
        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
        $respuesta["api_session"] = session_id();
        $_SESSION["usuario"] = $respuesta["usuario"]["usuario"];
        $_SESSION["clave"] = $respuesta["usuario"]["clave"];
    } else {
        $respuesta["mensaje"] = "El usuario no se encuentra registrado en la BD.";
    }
    $conexion = null;
    $sentencia = null;
    return $respuesta;
}

function logueado($usuario, $clave)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
    }
    try {
        $consulta = "SELECT * FROM usuarios WHERE usuario = ? AND clave = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$usuario, $clave]);
    } catch (PDOException $e) {
        $respuesta["error"] = "Error en la consulta: " . $e->getMessage();
    }

    if ($sentencia->rowCount() > 0) {
        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
    } else {
        $respuesta["mensaje"] = "El usuario no se encuentra registrado en la BD.";
    }
    $conexion = null;
    $sentencia = null;
    return $respuesta;
}

function obtener_datos_usuario($id_usuario)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
    }
    try {
        $consulta = "SELECT * FROM usuarios WHERE id_usuario = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$id_usuario]);
    } catch (PDOException $e) {
        $respuesta["error"] = "Error en la consulta: " . $e->getMessage();
    }

    if ($sentencia->rowCount() > 0) {
        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
    } else {
        $respuesta["mensaje"] = "El usuario con " . $id_usuario . " no se encuentra registrado en la BD.";
    }
    $conexion = null;
    $sentencia = null;
    return $respuesta;
}

function usuarios_guardia_dia_hora($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
    }
    try {
        $consulta = "SELECT usuarios.id_usuario, usuarios.nombre, usuarios.usuario, usuarios.clave, usuarios.email FROM usuarios, horario_guardias WHERE horario_guardias.usuario = usuarios.id_usuario AND horario_guardias.dia = ? AND horario_guardias.hora = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos);
    } catch (PDOException $e) {
        $respuesta["error"] = "Error en la consulta: " . $e->getMessage();
    }

    $respuesta["usuarios"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    $conexion = null;
    $sentencia = null;
    return $respuesta;
}

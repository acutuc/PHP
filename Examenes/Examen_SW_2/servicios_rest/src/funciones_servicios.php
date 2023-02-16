<?php
require "config_bd.php";

function login($datos)
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        $consulta = "select * from usuarios where usuario = ? and clave = ?";
        $sentencia = $conexion->prepare($consulta);
        if ($sentencia->execute($datos)) {

            if ($sentencia->rowCount() > 0) {

                $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
            } else {

                $respuesta["mensaje"] = "Usuario no encontrado en la BD";
            }
        } else {

            $respuesta["error"] = "Error en la consulta, num: " . $sentencia->errorInfo()[1] . " Error: " . $sentencia->errorInfo()[2];
        }
        $sentencia = null;
        $conexion = null;
    } catch (PDOException $e) {

        $respuesta["error"] = "Error en la conexion: " . $e->getMessage();
    }

    return $respuesta;
}

function obtener_horario_usuario($datos)
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        $consulta = "select horario_lectivo.dia, horario_lectivo.hora, grupos.nombre as nombre_grupo from horario_lectivo, grupos 
        where horario_lectivo.grupo = grupos.id_grupo and horario_lectivo.usuario = ?";
        $sentencia = $conexion->prepare($consulta);
        if ($sentencia->execute($datos)) {

            $respuesta["horario"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        } else {

            $respuesta["error"] = "Error en la consulta, num: " . $sentencia->errorInfo()[1] . " Error: " . $sentencia->errorInfo()[2];
        }
        $sentencia = null;
        $conexion = null;
    } catch (PDOException $e) {

        $respuesta["error"] = "Error en la conexion: " . $e->getMessage();
    }

    return $respuesta;
}

function obtener_usuarios()
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        $consulta = "select * from usuarios where tipo <> 'admin'";
        $sentencia = $conexion->prepare($consulta);
        if ($sentencia->execute()) {

            $respuesta["usuarios"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        } else {

            $respuesta["error"] = "Error en la consulta, num: " . $sentencia->errorInfo()[1] . " Error: " . $sentencia->errorInfo()[2];
        }
        $sentencia = null;
        $conexion = null;
    } catch (PDOException $e) {

        $respuesta["error"] = "Error en la conexion: " . $e->getMessage();
    }

    return $respuesta;
}

function obtener_grupos($datos)
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        $consulta = "select grupos.nombre from grupos, horario_lectivo where horario_lectivo.grupo = grupos.id_grupo 
        and horario_lectivo.dia = ? and horario_lectivo.hora = ? and horario_lectivo.usuario = ?";
        $sentencia = $conexion->prepare($consulta);
        if ($sentencia->execute($datos)) {

            $respuesta["grupos"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        } else {

            $respuesta["error"] = "Error en la consulta, num: " . $sentencia->errorInfo()[1] . " Error: " . $sentencia->errorInfo()[2];
        }
        $sentencia = null;
        $conexion = null;
    } catch (PDOException $e) {

        $respuesta["error"] = "Error en la conexion: " . $e->getMessage();
    }

    return $respuesta;
}

function obtener_grupos_libres($datos)
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        $consulta = "select * from grupos where (grupos.id_grupo, grupos.nombre) not in (select grupos.id_grupo, grupos.nombre from grupos, horario_lectivo where horario_lectivo.grupo = grupos.id_grupo 
        and horario_lectivo.dia = ? and horario_lectivo.hora = ? and horario_lectivo.usuario = ?)";
        $sentencia = $conexion->prepare($consulta);
        if ($sentencia->execute($datos)) {

            $respuesta["grupos_libres"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        } else {

            $respuesta["error"] = "Error en la consulta, num: " . $sentencia->errorInfo()[1] . " Error: " . $sentencia->errorInfo()[2];
        }
        $sentencia = null;
        $conexion = null;
    } catch (PDOException $e) {

        $respuesta["error"] = "Error en la conexion: " . $e->getMessage();
    }

    return $respuesta;
}

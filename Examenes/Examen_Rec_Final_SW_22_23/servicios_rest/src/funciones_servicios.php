<?php
require "config_bd.php";




function login($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {
            $consulta = "select * from usuarios where usuario=? and clave=?";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);
            if ($sentencia->rowCount() > 0) {
                $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);

                session_name("EXAM_FINAL_API_SW_22_23");
                session_start();
                $_SESSION["usuario"] = $datos[0];
                $_SESSION["clave"] = $datos[1];
                $_SESSION["tipo"] = $respuesta["usuario"]["tipo"];
                $respuesta["api_session"] = session_id();

            } else {
                $respuesta["mensaje"] = "El usuario no se encuentra registrado en la BD";
            }
        } catch (PDOException $e) {
            $respuesta["error"] = "Imposible realizar la consulta:" . $e->getMessage();
        }
        $sentencia = null;
        $conexion = null;
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    return $respuesta;
}

function logueado($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {
            $consulta = "select * from usuarios where usuario=? and clave=?";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);
            if ($sentencia->rowCount() > 0) {
                $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);

            } else {
                $respuesta["mensaje"] = "El usuario no se encuentra registrado en la BD";
            }
        } catch (PDOException $e) {
            $respuesta["error"] = "Imposible realizar la consulta:" . $e->getMessage();
        }
        $sentencia = null;
        $conexion = null;
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    return $respuesta;
}

function obtenerHorarios($id)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {
            $consulta = "SELECT dia, hora, grupos.nombre FROM horario_lectivo, grupos WHERE usuario = ? AND grupos.id_grupo = horario_lectivo.grupo";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute([$id]);

            $respuesta["horarios"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $respuesta["error"] = "Imposible realizar la consulta:" . $e->getMessage();
        }
        $sentencia = null;
        $conexion = null;
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    return $respuesta;
}

function obtenerHorariosDia($dia)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {
            $consulta = "SELECT usuarios.*, horario_lectivo.hora, grupos.nombre FROM usuarios, horario_lectivo, grupos WHERE horario_lectivo.dia = ? AND horario_lectivo.usuario = usuarios.id_usuario AND grupos.nombre = 'GUARD'";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute([$dia]);

            $respuesta["horario"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $respuesta["error"] = "Imposible realizar la consulta:" . $e->getMessage();
        }
        $sentencia = null;
        $conexion = null;
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    return $respuesta;
}
?>
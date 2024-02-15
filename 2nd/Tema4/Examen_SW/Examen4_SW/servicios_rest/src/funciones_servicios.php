<?php
require "config_bd.php";

function login($usuario, $clave)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    try {
        $consulta = "SELECT * FROM usuarios WHERE usuario = ? AND clave = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$usuario, $clave]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "Error en la consulta: " . $e->getMessage();
    }

    if ($sentencia->rowCount() > 0) {
        session_name("Examen_SW_23_24_API");
        session_start();
        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
        $respuesta["api_session"] = session_id();

        $_SESSION["usuario"] = $respuesta["usuario"]["usuario"];
        $_SESSION["clave"] = $respuesta["usuario"]["clave"];
        $_SESSION["tipo"] = $respuesta["usuario"]["tipo"];
    } else {
        $respuesta["mensaje"] = "El usuario no se encuentra registrado en la BD.";
    }

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function logueado($usuario, $clave)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    try {
        $consulta = "SELECT * FROM usuarios WHERE usuario = ? AND clave = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$usuario, $clave]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "Error en la consulta: " . $e->getMessage();
    }

    if ($sentencia->rowCount() > 0) {
        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
    } else {
        $respuesta["mensaje"] = "El usuario no se encuentra registrado en la BD.";
    }

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function obtener_datos_alumnos()
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    try {
        $consulta = "SELECT * FROM usuarios WHERE tipo = 'alumno'";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "Error en la consulta: " . $e->getMessage();
    }

    $respuesta["alumnos"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function notas_alumno($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    try {
        $consulta = "SELECT asignaturas.cod_asig, asignaturas.denominacion, notas.nota FROM asignaturas, notas, usuarios WHERE asignaturas.cod_asig = notas.cod_asig AND notas.cod_usu = usuarios.cod_usu AND usuarios.cod_usu = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "Error en la consulta: " . $e->getMessage();
    }

    $respuesta["notas"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

//REPASAR
function notas_no_eval_alumno($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    try {
        $consulta = "SELECT asignaturas.cod_asig, asignaturas.denominacion, notas.nota FROM asignaturas, notas, usuarios WHERE notas.nota NOT IN (SELECT asignaturas.cod_asig, asignaturas.denominacion, notas.nota FROM asignaturas, notas, usuarios WHERE asignaturas.cod_asig = notas.cod_asig AND notas.cod_usu = usuarios.cod_usu AND usuarios.cod_usu = ?)";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "Error en la consulta: " . $e->getMessage();
    }

    $respuesta["notas"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function quitar_nota($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    try {
        $consulta = "DELETE FROM notas WHERE notas.cod_asig = ? AND notas.cod_usu = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "Error en la consulta: " . $e->getMessage();
    }

    $respuesta["mensaje"] = "Asignatura descalificada con éxito";

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function poner_nota($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    try {
        $consulta = "UPDATE notas SET nota = '0' WHERE notas.cod_asig = ? AND notas.cod_usu = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "Error en la consulta: " . $e->getMessage();
    }

    $respuesta["mensaje"] = "Asignatura descalificada con éxito";

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function cambiar_nota($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    try {
        $consulta = "UPDATE notas SET nota = ? WHERE notas.cod_asig = ? AND notas.cod_usu = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "Error en la consulta: " . $e->getMessage();
    }

    $respuesta["mensaje"] = "Asignatura cambiada con éxito";

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}


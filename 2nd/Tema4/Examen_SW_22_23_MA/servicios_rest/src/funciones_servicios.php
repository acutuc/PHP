<?php
require "config_bd.php";

function conexion_pdo()
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        $respuesta["mensaje"] = "Conexi&oacute;n a la BD realizada con &eacute;xito";

        $conexion = null;
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    return $respuesta;
}

function login($lector, $clave)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }

    try {
        $consulta = "SELECT * FROM usuarios WHERE lector = ? AND clave = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$lector, $clave]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "Imposible realizar la consulta:" . $e->getMessage();
    }

    if ($sentencia->rowCount() > 0) {
        //INICIO DE SESIONES:
        session_name("examen_22_23");
        session_start();
        //Paso los datos del usuario y la api_session:
        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
        $respuesta["api_session"] = session_id();
        
        $_SESSION["usuario"] = $respuesta["usuario"]["lector"]; //$lector
        $_SESSION["clave"] = $respuesta["usuario"]["clave"]; //$clave
        $_SESSION["tipo"] = $respuesta["usuario"]["tipo"];
    } else {
        $respuesta["mensaje"] = "El usuario no se encuentra en la BD";
    }
    $conexion = null;
    $sentencia = null;
    return $respuesta;
}

function logueado($lector, $clave)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }

    try {
        $consulta = "SELECT * FROM usuarios WHERE lector = ? AND clave = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$lector, $clave]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "Imposible realizar la consulta:" . $e->getMessage();
    }

    if ($sentencia->rowCount() > 0) {
        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
    } else {
        $respuesta["mensaje"] = "El usuario no se encuentra en la BD";
    }
    $conexion = null;
    $sentencia = null;
    return $respuesta;
}

function obtener_libros()
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }

    try {
        $consulta = "SELECT * FROM libros";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "Imposible realizar la consulta:" . $e->getMessage();
    }

    $respuesta["libros"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    $conexion = null;
    $sentencia = null;
    return $respuesta;
}

function crear_libro($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }

    try {
        $consulta = "INSERT INTO libros (referencia, titulo, autor, descripcion, precio) VALUES (?, ?, ?, ?, ?)";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "Imposible realizar la consulta:" . $e->getMessage();
    }

    $respuesta["mensaje"] = "Libro insertado correctamente en la BD";

    $conexion = null;
    $sentencia = null;
    return $respuesta;
}

function actualizar_portada($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }

    try {
        $consulta = "UPDATE libros SET portada = ? WHERE referencia = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "Imposible realizar la consulta:" . $e->getMessage();
    }

    $respuesta["mensaje"] = "Portada cambiada correctamente en la BD";

    $conexion = null;
    $sentencia = null;
    return $respuesta;
}

function repetido($tabla, $columna, $valor)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }

    try {
        $consulta = "SELECT * FROM ".$tabla." WHERE ".$columna." = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$valor]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "Imposible realizar la consulta:" . $e->getMessage();
    }

    $respuesta["repetido"] = $sentencia->rowCount() > 0;

    $conexion = null;
    $sentencia = null;
    return $respuesta;
}

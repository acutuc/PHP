<?php

define('SERVIDOR_BD', 'localhost');
define('USUARIO_BD', 'jose');
define('CLAVE_BD', 'josefa');
define('NOMBRE_BD', 'bd_tienda');

function obtener_productos()
{

    //conexión PDO
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        return array("mensaje_error" => "No ha podido conectarse a la base de batos: " . $e->getMessage());
    }

    //consulta PDO
    try {
        $consulta = "SELECT * FROM producto";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        return array("mensaje_error" => "No se ha podido realizar la consulta: " . $e->getMessage());
    }

    //respuesta PDO
    $respuesta["productos"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function obtener_producto($producto)
{

    //conexión PDO
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        return array("mensaje_error" => "No ha podido conectarse a la base de batos: " . $e->getMessage());
    }

    //consulta PDO
    try {
        $consulta = "SELECT * FROM producto WHERE cod = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$producto]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        return array("mensaje_error" => "No se ha podido realizar la consulta: " . $e->getMessage());
    }

    //respuesta PDO
    if ($sentencia->rowCount() == 0) {
        $respuesta["mensaje"] = "El producto con código: " . $producto . " no se encuentra registrado en la BD";
    } else {
        $respuesta["producto"] = $sentencia->fetch(PDO::FETCH_ASSOC);
    }

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function insertar_producto($producto)
{

    //conexión PDO
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        return array("mensaje_error" => "No ha podido conectarse a la base de batos: " . $e->getMessage());
    }

    //consulta PDO
    try {
        $consulta = "INSERT INTO producto (cod, nombre, nombre_corto, descripcion, PVP, familia) values (?, ?, ?, ?, ?, ?)";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($producto);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        return array("mensaje_error" => "No se ha podido realizar la consulta: " . $e->getMessage());
    }

    //respuesta PDO
    $respuesta["mensaje"] = "El producto " . $producto[2] . " se ha insertado en la BD";
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function actualizar_producto($datos)
{

    //conexión PDO
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        return array("mensaje_error" => "No ha podido conectarse a la base de batos: " . $e->getMessage());
    }

    //consulta PDO
    try {
        $consulta = "UPDATE producto SET nombre = ?, nombre_corto = ?, descripcion = ?, PVP = ?, familia = ? WHERE cod = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        return array("mensaje_error" => "No se ha podido realizar la consulta: " . $e->getMessage());
    }

    //respuesta PDO
    $respuesta["mensaje"] = "El producto " . $datos[2] . " se ha actualizado correctamente";
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function borrar_producto($codigo)
{

    //conexión PDO
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        return array("mensaje_error" => "No ha podido conectarse a la base de batos: " . $e->getMessage());
    }

    //consulta PDO
    try {
        $consulta = "DELETE FROM producto WHERE cod = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$codigo]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        return array("mensaje_error" => "No se ha podido realizar la consulta: " . $e->getMessage());
    }

    if ($sentencia->rowCount() > 0) {
        $respuesta["mensaje"] = "El producto " . $codigo . " se ha borrado correctamente";
    } else {
        $respuesta["mensaje"] = "El producto " . $codigo . " NO se encontraba en la BD";
    }

    //respuesta PDO
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function obtener_familias()
{

    //conexión PDO
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        return array("mensaje_error" => "No ha podido conectarse a la base de batos: " . $e->getMessage());
    }

    //consulta PDO
    try {
        $consulta = "SELECT * FROM familia";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        return array("mensaje_error" => "No se ha podido realizar la consulta: " . $e->getMessage());
    }

    //respuesta PDO
    $respuesta["familias"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function repetido_insertar($tabla, $columna, $valor)
{
    //conexión PDO
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        return array("mensaje_error" => "No ha podido conectarse a la base de batos: " . $e->getMessage());
    }

    //consulta PDO
    try {
        $consulta = "SELECT * FROM ".$tabla." WHERE ".$columna." = ?";
        $sentencia = $conexion->prepare($consulta);

        $sentencia->execute([$valor]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        return array("mensaje_error" => "No se ha podido realizar la consulta: " . $e->getMessage());
    }

    //respuesta PDO
    //Devuelve true o false:
    $respuesta["repetido"] = ($sentencia->rowCount()) > 0;
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function repetido_editar($tabla, $columna, $valor, $columna_id, $valor_id)
{
    //conexión PDO
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        return array("mensaje_error" => "No ha podido conectarse a la base de batos: " . $e->getMessage());
    }

    //consulta PDO
    try {
        $consulta = "SELECT * FROM ".$tabla." WHERE ".$columna." = ? AND ".$columna_id." <> ?";
        $sentencia = $conexion->prepare($consulta);

        $sentencia->execute([$valor, $valor_id]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        return array("mensaje_error" => "No se ha podido realizar la consulta: " . $e->getMessage());
    }

    //respuesta PDO
    //Devuelve true o false:
    $respuesta["repetido"] = ($sentencia->rowCount()) > 0;
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}
<?php
require "bd_config.php";

function login($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        try {
            $consulta = "select * from usuarios where usuario=? and clave=?";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);

            if ($sentencia->rowCount() > 0)
                $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
            else
                $respuesta["mensaje"] = "Usuario no registrado en BD";

            $sentencia = null;
            $conexion = null;
        } catch (PDOException $e) {
            $respuesta["mensaje_error"] = "Imposible realizar la consulta. Error:" . $e->getMessage();
        }


    } catch (PDOException $e) {
        $respuesta["mensaje_error"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
    }

    return $respuesta;
}

function obtener_productos()
{
    try {
        $conexion = $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {
            $consulta = "SELECT * FROM productos";

            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute();

            if ($sentencia->rowCount() > 0) {
                //Devolvemos los datos del usuario:
                $respuesta["productos"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $respuesta["mensaje"] = "No existen productos en la BD";
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

function insertar_producto($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        try {
            $consulta = "INSERT INTO productos(fecha_recepcion, nombre_producto, cantidad, unidad_medida, precio_unitario, consumido, id_almacen) VALUES(?, ?, ?, ?, ?, 0, 1)";

            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);

            $respuesta["ultimo_id"] = $conexion->lastInsertId();

            $sentencia = null;
            $conexion = null;
        } catch (PDOException $e) {
            $respuesta["mensaje_error"] = "Imposible realizar la consulta. Error:" . $e->getMessage();
        }
    } catch (PDOException $e) {
        $respuesta["mensaje_error"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
    }
    return $respuesta;
}

function obtener_usuario($id)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        try {
            $consulta = "SELECT * FROM usuarios WHERE id_usuario = ?";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute([$id]);

            if ($sentencia->rowCount() > 0)
                $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
            else
                $respuesta["mensaje"] = "Usuario no registrado en BD";

            $sentencia = null;
            $conexion = null;
        } catch (PDOException $e) {
            $respuesta["mensaje_error"] = "Imposible realizar la consulta. Error:" . $e->getMessage();
        }
    } catch (PDOException $e) {
        $respuesta["mensaje_error"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
    }
    return $respuesta;
}

function borrar_usuario($id)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        try {
            $consulta = "DELETE FROM usuarios WHERE id_usuario = ?";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute([$id]);

            $respuesta["mensaje"] = "Usuario borrado de la BD";

            $sentencia = null;
            $conexion = null;
        } catch (PDOException $e) {
            $respuesta["mensaje_error"] = "Imposible realizar la consulta. Error:" . $e->getMessage();
        }
    } catch (PDOException $e) {
        $respuesta["mensaje_error"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
    }
    return $respuesta;
}


function repetido($columna, $valor)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        try {
            $consulta = "SELECT " . $columna . " FROM usuarios WHERE " . $columna . " = ?";

            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute([$valor]);

            $respuesta["repetido"] = $sentencia->rowCount() > 0;

            $sentencia = null;
            $conexion = null;
        } catch (PDOException $e) {
            $respuesta["mensaje_error"] = "Imposible realizar la consulta. Error:" . $e->getMessage();
        }
    } catch (PDOException $e) {
        $respuesta["mensaje_error"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
    }
    return $respuesta;
}

function insertar_usuario($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        try {
            $consulta = "INSERT INTO usuarios(usuario, clave, nombre, dni,sexo, subscripcion) VALUES(?,?,?,?,?,?)";

            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);

            $respuesta["ultimo_id"] = $conexion->lastInsertId();

            $sentencia = null;
            $conexion = null;
        } catch (PDOException $e) {
            $respuesta["mensaje_error"] = "Imposible realizar la consulta. Error:" . $e->getMessage();
        }
    } catch (PDOException $e) {
        $respuesta["mensaje_error"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
    }
    return $respuesta;
}


function cambiar_foto($id, $foto)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        try {
            $consulta = "UPDATE usuarios SET foto = ? WHERE id_usuario = ?";

            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute([$foto, $id]);

            $respuesta["mensaje"] = "Foto actualizada";

            $sentencia = null;
            $conexion = null;
        } catch (PDOException $e) {
            $respuesta["mensaje_error"] = "Imposible realizar la consulta. Error:" . $e->getMessage();
        }
    } catch (PDOException $e) {
        $respuesta["mensaje_error"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
    }
    return $respuesta;
}

?>
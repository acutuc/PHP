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
            $consulta = "INSERT INTO productos(fecha_recepcion, nombre_producto, cantidad, unidad_medida, precio_unitario, consumido, id_almacen) VALUES(?, ?, ?, ?, ?, ?, 1)";

            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);

            //$respuesta["ultimo_id"] = $conexion->lastInsertId();
            $respuesta["id_producto"] = $conexion->lastInsertId();
            $respuesta["fecha_recepcion"] = $datos[0];
            $respuesta["nombre_producto"] = $datos[1];
            $respuesta["cantidad"] = $datos[2];
            $respuesta["unidad_medida"] = $datos[3];
            $respuesta["precio_unitario"] = $datos[4];
            $respuesta["consumido"] = $datos[5];

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

function actualizar_productos($datos)
{
    $respuesta = array();

    try
    {
        $conexion = new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); 
        try
        {
            // Preparar la consulta de actualización
            $consulta = "UPDATE productos SET cantidad = cantidad - ?, consumido = consumido + ? WHERE id_producto = ?";
            $sentencia = $conexion->prepare($consulta);

            // Iterar sobre los datos para actualizar los productos
            foreach ($datos as $producto)
            {
                $sentencia->execute([$producto['cantidad'], $producto['cantidad'], $producto['id_producto']]);
            }
          
            $respuesta["mensaje"] = "Los productos han sido actualizados correctamente";

            $sentencia = null;
            $conexion = null;
        }
        catch(PDOException $e)
        {
            $respuesta["mensaje_error"] = "Imposible realizar la consulta. Error: " . $e->getMessage();
        }
    }
    catch(PDOException $e)
    {
        $respuesta["mensaje_error"] = "Imposible conectar a la BD. Error: " . $e->getMessage();
    }

    return $respuesta;
}

?>
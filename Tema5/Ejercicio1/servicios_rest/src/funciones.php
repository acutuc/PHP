<?php
function obtener_productos()
{
    //Conectamos a la BD:
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        //CONECTAMOS AQUÍ!!!!!!!:
        try {
            $consulta = "SELECT * FROM producto";

            //Preparamos la sentencia:
            $sentencia = $conexion->prepare($consulta);

            //Ejecutamos la sentencia:
            $sentencia->execute();

            $respuesta["productos"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $respuesta["mensaje_error"] = "Imposible conectar. Error: " . $e->getMessage();
        }
    } catch (PDOException $e) {
        $respuesta["mensaje_error"] = "Imposible conectar. Error: " . $e->getMessage();
    }

    return $respuesta;
}

function obtener_producto($cod)
{
    //Conectamos a la BD:
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        //CONECTAMOS AQUÍ!!!!!!!:
        try {
            $consulta = "SELECT * FROM producto WHERE cod = ?";

            //Preparamos la sentencia:
            $sentencia = $conexion->prepare($consulta);

            //Metemos los datos:
            $datos[] = $cod;

            //Ejecutamos la sentencia:
            $sentencia->execute($datos);

            $respuesta["producto"] = $sentencia->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $respuesta["mensaje_error"] = "Imposible conectar. Error: " . $e->getMessage();
        }
    } catch (PDOException $e) {
        $respuesta["mensaje_error"] = "Imposible conectar. Error: " . $e->getMessage();
    }

    return $respuesta;
}

function insertar_producto(){
    
}
?>
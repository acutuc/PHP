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


function conexion_mysqli()
{
    try {
        $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
        mysqli_set_charset($conexion, "utf8");
        $respuesta["mensaje"] = "Conexi&oacute;n a la BD realizada con &eacute;xito";
        mysqli_close($conexion);
    } catch (Exception $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    return $respuesta;
}

//MIS SERVICIOS:

//d)
function obtenerLibros()
{
    try {
        //Conectamos
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try{
            //Consultamos
            $consulta = "SELECT * FROM libros";

            //Creamos la sentencia
            $sentencia = $conexion->prepare($consulta);

            //Ejecutamos la sentencia
            $sentencia->execute();

            //Respuesta con fetchAll de todos los libros
            $respuesta["libros"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            $respuesta["error"] = "Imposible realizar la consulta: ".$e->getMessage();
        }
        //IMPORTANTE ANULAR SENTENCIA Y CONEXION:
        $sentencia = null;
        $conexion = null;
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    //Devolvemos respuesta
    return $respuesta;
}


?>
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

function login($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        try {
            $consulta = "SELECT * FROM usuarios WHERE usuario = ? AND clave = ?";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);

            if ($sentencia->rowCount() > 0) {
                $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
                session_name("examen_final_api");
                session_start();
                $_SESSION["usuario"] = $respuesta["usuario"]["usuario"];
                $_SESSION["clave"] = $respuesta["usuario"]["clave"];
                $respuesta["api_session"] = session_id();
            } else
                $respuesta["mensaje"] = "Usuario no registrado en BD";

            $sentencia = null;
            $conexion = null;
        } catch (PDOException $e) {
            $respuesta["error"] = "Imposible realizar la consulta. Error:" . $e->getMessage();
        }


    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
    }

    return $respuesta;
}

function logueado($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {
            $consulta = "SELECT * FROM usuarios WHERE usuario = ? AND clave = ?";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);

            if ($sentencia->rowCount() > 0) {
                $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
            } else {
                $respuesta["mensaje"] = "Usuario no se encuentra registrado en la BD.";
            }

        } catch (PDOException $e) {
            $respuesta["error"] = "Error de consulta:" . $e->getMessage();
        }
        $conexion = null;
        $sentencia = null;
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
    }
    return $respuesta;
}

function guardias_usuario($id)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try{
            $consulta = "SELECT horario_guardias.dia, horario_guardias.hora FROM horario_guardias, usuarios WHERE usuarios.id_usuario = ? AND usuarios.id_usuario = horario_guardias.usuario";
            
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute([$id]);

            if($sentencia->rowCount() > 0){
                $respuesta["guardias"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            }else{
                $respuesta["error"] = "El usuario con el id ".$id." no existe en la BD.";
            }
        }catch(PDOException $e){
            $respuesta["error"] = "Error de consulta:" . $e->getMessage();
        }
        $conexion = null;
        $sentencia = null;
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
    }
    return $respuesta;
}
?>
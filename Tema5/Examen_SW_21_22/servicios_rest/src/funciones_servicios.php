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
        @$conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
        mysqli_set_charset($conexion, "utf8");
        $respuesta["mensaje"] = "Conexi&oacute;n a la BD realizada con &eacute;xito";
        mysqli_close($conexion);
    } catch (Exception $e) {
        $respuesta["error"] = "Imposible conectar:" . mysqli_connect_errno() . " : " . mysqli_connect_error();
    }
    return $respuesta;
}

function login($datos, $in_log = true)
{
    try {
        //Intenta conectar:
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        //Si conecta:
        try {
            //Hacemos la consulta:
            $consulta = "SELECT * FROM usuarios WHERE usuario = ? AND clave = ?";
            //Preparamos la consulta, y ejecutamos luego con los datos que pasamos por parámetro a la conexión:
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);

            //Si hemos obtenido datos, es que nos hemos logueado:
            if ($sentencia->rowCount() > 0) {
                //Almacemnamos los datos del usuario en el array $respuesta:
                $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);

                //Protegemos, comprobamos si existían sesiones o no, con el segundo parámetro pasado a la función:
                if ($in_log) {
                    //Creamos la sesión y guardamos el tipo de usuario en la sesión:
                    session_name("Examen_API_21_22");
                    session_start();
                    $_SESSION["usuario"] = $datos[0];
                    $_SESSION["clave"] = $datos[1];
                    $_SESSION["tipo"] = $respuesta["usuario"]["tipo"];
                    //Guardamos la última id:
                    $respuesta["api_session"] = session_id();
                }
                //Si el usuario no está registrado:
            } else {
                $respuesta["mensaje"] = "El usuario no se encuentra registrado en la BD.";
            }
        } catch (PDOException $e) {
            $respuesta["error"] = "Imposible realizar la consulta. Error: " . $e->getMessage();
        }
        //Cerramos sentencia y conexion:
        $sentencia = null;
        $conexion = null;
    } catch (PDOException $e) {
        $respuesta["error"] = json_encode(array("error" => "Imposible realizar la consulta. Error: " . $e->getMessage()));
    }
    return $respuesta;
}

function obtener_horario($id_usuario)
{
    try {
        //Intenta conectar:
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        //Si conecta:
        try {
            //Hacemos la consulta:
            $consulta = "SELECT horario_lectivo.dia, horario_lectivo.hora, grupos.nombre FROM horario_lectivo, grupos WHERE horario_lectivo.grupo = grupos.id_grupo AND horario_lectivo.usuario = ?";
            //Preparamos la consulta, y ejecutamos
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute([$id_usuario]);
            //Almacemnamos los datos del horario en el array $respuesta:
            $respuesta["horario"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $respuesta["error"] = "Imposible realizar la consulta. Error: " . $e->getMessage();
        }
        //Cerramos sentencia y conexion:
        $sentencia = null;
        $conexion = null;
    } catch (PDOException $e) {
        $respuesta["error"] = json_encode(array("error" => "Imposible realizar la consulta. Error: " . $e->getMessage()));
    }
    return $respuesta;
}
?>
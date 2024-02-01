<?php
define("SERVIDOR_BD", "localhost");
define("USUARIO_BD", "jose");
define("CLAVE_BD", "josefa");
define("NOMBRE_BD", "bd_foro");


//En el login, tenemos que devolver el token de api_key si o si
function login($usuario, $clave)
{
    //Conexión
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        return array("error" => "No se ha podido conectar a la base de batos: " . $e->getMessage());
    }
    //Consulta
    try {
        $consulta = "SELECT * FROM usuarios WHERE usuario=? AND clave=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$usuario, $clave]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        return array("error" => "No se ha podido realizar la consulta: " . $e->getMessage());
    }

    //Respuesta
    if ($sentencia->rowCount() > 0) {
        //CREAMOS LA SESION Y GUARDAMOS LAS VARIABLES PARA LA API:
        session_name("Api_foro");
        session_start();
        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
        //METEMOS EN respuesta LA api_key;
        $respuesta["api_key"] = session_id();

        $_SESSION["usuario"] = $usuario;
        $_SESSION["clave"] = $clave;
        $_SESSION["tipo"] = $respuesta["usuario"]["tipo"]; //Cogemos el tipo del fetch de arriba
    } else {
        $respuesta["mensaje"] = "El usuario no se encuentra en la BD";
    }

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function logueado($usuario, $clave)
{
    //Conexión
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        return array("error" => "No se ha podido conectar a la base de batos: " . $e->getMessage());
    }
    //Consulta
    try {
        $consulta = "SELECT * FROM usuarios WHERE usuario=? AND clave=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$usuario, $clave]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        return array("error" => "No se ha podido realizar la consulta: " . $e->getMessage());
    }

    //Respuesta
    if ($sentencia->rowCount() > 0) {
        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
    } else {
        $respuesta["mensaje"] = "El usuario no se encuentra en la BD";
    }

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function obtener_usuario($id_usuario)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {

        return array("error" => "No se ha podido conectar a la base de batos: " . $e->getMessage());
    }
    try {
        $consulta = "select * from usuarios where id_usuario=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$id_usuario]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        return array("error" => "No se ha podido realizar la consulta: " . $e->getMessage());
    }


    $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}


function obtener_usuarios()
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {

        return array("error" => "No se ha podido conectar a la base de batos: " . $e->getMessage());
    }
    try {
        $consulta = "select * from usuarios";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        return array("error" => "No se ha podido realizar la consulta: " . $e->getMessage());
    }


    $respuesta["usuarios"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}


function insertar_usuario($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {

        return array("error" => "No se ha podido conectar a la base de batos: " . $e->getMessage());
    }
    try {
        $consulta = "insert into usuarios (nombre,usuario,clave,email) values (?,?,?,?)";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        return array("error" => "No se ha podido realizar la consulta: " . $e->getMessage());
    }


    $respuesta["ult_id"] = $conexion->lastInsertId();

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}


function actualizar_usuario($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {

        return array("error" => "No se ha podido conectar a la base de batos: " . $e->getMessage());
    }
    try {
        $consulta = "update usuarios set nombre=?, usuario=?, clave=?, email=? where id_usuario=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        return array("error" => "No se ha podido realizar la consulta: " . $e->getMessage());
    }

    if ($sentencia->rowCount() > 0) {
        $respuesta["mensaje"] = "El usuario con id: " . $datos[4] . " se ha actualizado con éxito";
    } else {
        $respuesta["mensaje_error"] = "El usuario con id: " . $datos[4] . " no se encuentra en la BD";
    }

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}


function actualizar_usuario_sin_clave($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {

        return array("error" => "No se ha podido conectar a la base de batos: " . $e->getMessage());
    }
    try {
        $consulta = "update usuarios set nombre=?, usuario=?, email=? where id_usuario=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        return array("error" => "No se ha podido realizar la consulta: " . $e->getMessage());
    }

    if ($sentencia->rowCount() > 0) {
        $respuesta["mensaje"] = "El usuario con id: " . $datos[3] . " se ha actualizado con éxito";
    } else {
        $respuesta["mensaje_error"] = "El usuario con id: " . $datos[3] . " no se encuentra en la BD";
    }
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function borrar_usuario($id_usuario)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {

        return array("error" => "No se ha podido conectar a la base de batos: " . $e->getMessage());
    }
    try {
        $consulta = "delete from usuarios where id_usuario=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$id_usuario]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        return array("error" => "No se ha podido realizar la consulta: " . $e->getMessage());
    }

    $respuesta["mensaje"] = "El usuario con id: " . $id_usuario . " se ha actualizado con éxito";


    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function repetido($tabla, $columna, $valor, $columna_id = null, $valor_id = null)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {

        return array("error" => "No se ha podido conectar a la base de batos: " . $e->getMessage());
    }
    try {
        if (isset($columna_id)) {
            $consulta = "select * from " . $tabla . " where " . $columna . "=? AND " . $columna_id . "<>?";
            $datos = [$valor, $valor_id];
        } else {
            $consulta = "select * from " . $tabla . " where " . $columna . "=?";
            $datos = [$valor];
        }
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        return array("error" => "No se ha podido realizar la consulta: " . $e->getMessage());
    }

    $respuesta["repetido"] = ($sentencia->rowCount()) > 0;
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

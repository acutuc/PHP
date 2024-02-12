<?php
require "config_bd.php";

function conexion_pdo()
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        
        $respuesta["mensaje"]="Conexi&oacute;n a la BD realizada con &eacute;xito";
        
        $conexion=null;
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }
    return $respuesta;
}


function conexion_mysqli()
{
  
    try
    {
        $conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
        mysqli_set_charset($conexion,"utf8");
        $respuesta["mensaje"]="Conexi&oacute;n a la BD realizada con &eacute;xito";
        mysqli_close($conexion);
    }
    catch(Exception $e)
    {
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }
    return $respuesta;
}

function login($usuario, $clave)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }
    
    try{
        $consulta = "SELECT * FROM usuarios WHERE usuario = ? AND clave = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$usuario, $clave]);
    }
    catch(PDOException $e){
        $conexion = null;
        $sentencia = null;
        $respuesta["error"]="Error en la consulta:".$e->getMessage();
    }

    if($sentencia->rowCount() > 0){
        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
        session_name("nombre_de_la_api");
        session_start();
        $_SESSION["usuario"] = $respuesta["usuario"]["usuario"];
        $_SESSION["clave"] = $respuesta["usuario"]["clave"];
        $_SESSION["tipo"] = $respuesta["usuario"]["tipo"];
        $respuesta["api_session"] = session_id();
    }else{
        $respuesta["mensaje"] = "El usuario no se encuentra registrado en la BD";
    }

    return $respuesta;
}

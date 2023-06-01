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

function login($datos)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        try{
            //Realizamos la consulta
            $consulta = "SELECT * FROM usuarios WHERE usuario = ? AND clave = ?";
            
            //Inicializamos una instancia en sentencia, preparando la consulta
            $sentencia = $conexion->prepare($consulta);

            //Ejecutamos la sentencia con los datos:
            $sentencia->execute($datos);

            //Si obtenemos tuplas, existe usuario y contraseña:
            if($sentencia->rowCount() > 0){
                //Almacenamos todos los datos del usuario:
                $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);

                //Nombramos e iniciamos las sesiones:
                session_name("examen22_23");
                session_start();

                //Almacenamos los datos del usuario en los $_SESSION:
                $_SESSION["usuario"] = $respuesta["usuario"]["usuario"];
                $_SESSION["clave"] = $respuesta["usuario"]["clave"];

                //Pasamos la api_session a $respuesta
                $respuesta["api_session"] = session_id();
            }else{
                $respuesta["mensaje"] = "Usuario no se encuentra registrado en la BD";
            }

            $sentencia = null;
            $conexion=null;
        }catch(PDOException $e){
            $respuesta["error"]="Imposible realizar la consulta. Error:".$e->getMessage();
        }        
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }
    return $respuesta;
}

//La función logueado es la típica que hemos hecho siempre, sin las sesiones:
function logueado($datos)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        try{
            $consulta = "SELECT * FROM usuarios WHERE usuario = ? AND clave = ?";
            $sentencia = $conexion->prepare($consulta);

            $sentencia->execute($datos);

            if($sentencia->rowCount() > 0){
                $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
            }else{
                $respuesta["mensaje"] = "Usuario no se encuentra registrado en la BD";
            }

            $sentencia = null;
            $conexion=null;
        }catch(PDOException $e){
            $respuesta["error"]="Imposible realizar la consulta. Error:".$e->getMessage();
        }        
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }
    return $respuesta;
}

function obtener_usuario($id)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        try{
            $consulta = "SELECT * FROM usuarios WHERE id_usuario = ?";
            $sentencia = $conexion->prepare($consulta);

            //EJECUTAMOS CON ARRAY, solo tenemos un dato.
            $sentencia->execute([$id]);

            if($sentencia->rowCount() > 0){
                $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
            }else{
                $respuesta["mensaje"] = "Usuario con id ".$id." no se encuentra registrado en la BD";
            }

            $sentencia = null;
            $conexion=null;
        }catch(PDOException $e){
            $respuesta["error"]="Imposible realizar la consulta. Error:".$e->getMessage();
        }        
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }
    return $respuesta;
}

function obtener_usuarios($datos)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        try{
            $consulta = "SELECT usuarios.* FROM  WHERE  = ?";
            $sentencia = $conexion->prepare($consulta);

            $sentencia->execute($datos);

            if($sentencia->rowCount() > 0){
                $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
            }else{
                $respuesta["mensaje"] = "Usuario con id ".$id." no se encuentra registrado en la BD";
            }

            $sentencia = null;
            $conexion=null;
        }catch(PDOException $e){
            $respuesta["error"]="Imposible realizar la consulta. Error:".$e->getMessage();
        }        
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }
    return $respuesta;
}

?>

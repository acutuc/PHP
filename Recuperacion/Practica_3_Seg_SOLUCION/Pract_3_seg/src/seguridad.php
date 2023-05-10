<?php
define("MINUTOS", 5);

$url=DIR_SERV."/logueado";
$respuesta=consumir_servicios_REST($url,"POST",$_SESSION["api_session"]);
$obj=json_decode($respuesta);
if(!$obj)
{
    session_destroy();
    die(error_page("Práctica 3 - SW","Práctica 3 - SW","Error consumiendo el servicio: ".$url));
}
if(isset($obj->mensaje_error))
{
    session_destroy();
    die(error_page("Práctica 3 - SW","Práctica 3 - SW",$obj->mensaje_error));
}

if(isset($obj->no_login))
{
    session_unset();
    $_SESSION["seguridad"]="El tiempo de sesión de la API ha expirado";
    header("Location:index.php");
    exit;
}

if(isset($obj->mensaje))
{
    
    consumir_servicios_REST(DIR_SERV."/salir","POST",$_SESSION["api_session"]);
    session_unset();
    $_SESSION["seguridad"]="Usted ya no se encuentra registrado en la BD";
    header("Location:index.php");
    exit;
}


$datos_usu_log=$obj->usuario;

if(time()-$_SESSION["ultima_accion"]>MINUTOS*60)
{
    consumir_servicios_REST(DIR_SERV."/salir","POST",$_SESSION["api_session"]);
    session_unset();
    $_SESSION["seguridad"]="Su tiempo de sesión ha expirado";
    header("Location:index.php");
    exit;
}
$_SESSION["ultima_accion"]=time();
?>
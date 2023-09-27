<?php


$url=DIR_SERV."/logueado";
$respuesta=consumir_servicios_REST($url,"POST",$_SESSION["api_session"]);
$obj=json_decode($respuesta);
if(!$obj)
{
    consumir_servicios_REST(DIR_SERV."/salir","POST",$_SESSION["api_session"]);
    session_destroy();
    die(error_page("Examen Final PHP","<h1>Examen Final PHP</h1><p>Error consumiendo el servicio: ".$url."</p>".$respuesta ));
}
if(isset($obj->error))
{
    consumir_servicios_REST(DIR_SERV."/salir","POST",$_SESSION["api_session"]);
    session_destroy();
    die(error_page("Examen Final PHP","<h1>Examen Final PHP</h1><p>".$obj->error."</p>"));
}

if(isset($obj->no_login))
{
    session_unset();
    $_SESSION["seguridad"]="El tiempo de sesión de la API ha expirado";
    header("Location:index.php");
    exit;
}


if(isset($obj->usuario))
{
    $datos_usuario_log=$obj->usuario;
   
}
else
{
    consumir_servicios_REST(DIR_SERV."/salir","POST",$_SESSION["api_session"]);
    session_unset();
    $_SESSION["seguridad"]="Usted no se encuentra registrado en la BD";
    header("Location:index.php");
    exit;
}

if(time()-$_SESSION["ultimo_acceso"]>MINUTOS*60)
{
    consumir_servicios_REST(DIR_SERV."/salir","POST",$_SESSION["api_session"]);
    session_unset();
    $_SESSION["seguridad"]="Su tiempo de sesión ha caducado. Vuelva a loguearse o registrarse";
    header("Location:index.php");
    exit;
}

$_SESSION["ultimo_acceso"]=time();


?>
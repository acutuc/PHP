<?php
//Pasamos la api_key al servicio:
$datos["api_key"] = $_SESSION["api_key"];

$datos["usuario"] = $_SESSION["usuario"];
$datos["clave"] = $_SESSION["clave"];

//Llamamos al servicio:
$url = DIR_SERV . "/logueado";
$respuesta = consumir_servicios_REST($url, "POST", $datos);

//Creamos el json de la respuesta obtenida:
$obj = json_decode($respuesta);

//Comprobamos, de la respuesta obtenida, los distintos tipos de errores (mensaje_error, mensaje):
//Si no hemos obtenido un json:
if (!$obj) {
    session_destroy();
    die(error_page("App Login", $respuesta));
}

//Si hemos obtenido mensaje_error:
if (isset($obj->mensaje_error)) {
    session_destroy();
    die(error_page("App Login", $obj->mensaje_error));
}

if(isset($obj->no_login)){
    session_unset();
    $_SESSION["seguridad"] = "El tiempo de sesión de la api ha expirado";
    header("Location:index.php");
    exit();
}

//Si existe mensaje, es que nos han baneado:
if (isset($obj->mensaje)) {
    session_unset();
    $_SESSION["seguridad"] = "Usted ya no se encuentra registrado en la BD";
    header("Location:index.php");
    exit();
}

//Recogemos los datos del usuario logueado:
$datos_usu_log = $obj->usuario;

//Comprobamos el tiempo que lleva de sesion:
if (time() - $_SESSION["ultima_accion"] > MINUTOS * 60) {
    session_unset();
    $_SESSION["seguridad"] = "El tiempo de sesión ha expirado";
    header("Location:index.php");
    exit();
}

//Refrescamos el tiempo:
$_SESSION["ultima_accion"] = time();

<?php
$url = DIR_SERV . "/logueado";
$datos["api_session"] = $_SESSION["api_session"];
$respuesta = consumir_servicios_REST($url, "GET", $datos);
$obj = json_decode($respuesta);

if (!$obj) {
    session_destroy();
    die(error_page("Gestión de Guardias", $url));
}
if (isset($obj->error)) {
    session_destroy();
    die(error_page("Gestión de Guardias", $obj->error));
}
if (isset($obj->mensaje)) {
    session_unset();
    $_SESSION["mensaje"] = $obj->mensaje;
    header("Location:index.php");
    exit();
}

$datos_usu_log = $obj->usuario;

if(time() - $_SESSION["ultima_accion"] > MINUTOS * 60){
    session_unset();
    $_SESSION["mensaje"] = "El tiempo de sesión ha expirado";
    header("Location:index.php");
    exit();
}

$_SESSION["ultima_accion"] = time();
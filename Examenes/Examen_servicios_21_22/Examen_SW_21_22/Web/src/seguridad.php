<?php
$url = DIR_SERV . "/logueado";

$respuesta = consumir_servicios_REST($url, "POST", $_SESSION["api_session"]);

$obj = json_decode($respuesta);

if (!$obj) {
    $url = DIR_SERV . "/salir";
    consumir_servicios_REST($url, "POST", $_SESSION["api_session"]);
    session_destroy();
    die(error_page("Examen4 PHP", "Examen4 PHP", $url . $respuesta));
}

if (isset($obj->error)) {
    $url = DIR_SERV . "/salir";
    consumir_servicios_REST($url, "POST", $_SESSION["api_session"]);
    session_destroy();
    die(error_page("Examen4 PHP", "Examen4 PHP", $obj->error));
}

if (isset($obj->no_auth)) {
    session_unset();
    $_SESSION["seguridad"] = "El tiempo de sesión de la API ha expirado";
    header("Location:index.php");
    exit();
}

if (isset($obj->mensaje)) {
    $error_usuario = true;
}

$datos_usu_log = $obj->usuario;

if(time() - $_SESSION["ultima_accion"] > MINUTOS * 60){
    $url = DIR_SERV . "/salir";
    consumir_servicios_REST($url, "POST", $_SESSION["api_session"]);
    session_unset();
    $_SESSION["seguridad"] = "Su tiempo de sesión ha caducado. Vuelva a loguearse";
    header("Location:index.php");
    exit();
}

$_SESSION["ultima_accion"] = time();
?>
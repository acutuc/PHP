<?php
define("MINUTOS", 10);

$url = DIR_SERV . "/logueado";

$respuesta = consumir_servicios_REST($url, "POST", $_SESSION["api_session"]);

$obj = json_decode($respuesta);

if (!$obj) {
    consumir_servicios_REST(DIR_SERV . "/salir", "POST", $_SESSION["api_session"]);
    session_destroy();
    die(error_page("Gestión de Guardias", "Gestión de Guardias", "Error consumiendo el servicio: " . $url . $respuesta));
}
if (isset($obj->error)) {
    consumir_servicios_REST(DIR_SERV . "/salir", "POST", $_SESSION["api_session"]);
    session_destroy();
    die(error_page("Gestión de Guardias", "Gestión de Guardias", $obj->error));
}
if (isset($obj->mensaje)) {
    consumir_servicios_REST(DIR_SERV . "/salir", "POST", $_SESSION["api_session"]);
    session_unset();
    $_SESSION["seguridad"] = "Ha sido baneado de la BD";
    header("Location:index.php");
    exit;
}
if (isset($obj->logout)) {
    session_unset();
    $_SESSION["seguridad"] = "El tiempo de sesión de la API ha expirado";
    header("Location:index.php");
    exit;
}

$datos_usu_log = $obj->usuario;

if (time() - $_SESSION["ultimo_acceso"] > MINUTOS * 60) {
    consumir_servicios_REST(DIR_SERV . "/salir", "POST", $_SESSION["api_session"]);
    session_unset();
    $_SESSION["seguridad"] = "Su tiempo de sesión ha expirado";
    header("Location:index.php");
    exit();
}

$_SESSION["ultimo_acceso"] = time();
?>
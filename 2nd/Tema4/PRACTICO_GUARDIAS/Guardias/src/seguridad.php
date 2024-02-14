<?php
$url = DIR_SERV . "/logueado";
$datos["api_session"] = $_SESSION["api_session"];
$respuesta = consumir_servicios_REST($url, "GET", $datos);
$obj = json_decode($respuesta);

if (!$obj) {
    consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos);
    session_destroy();
    die(error_page("Gestión de Guardias", "<p>" . $url . "</p>"));
}
if (isset($obj->error)) {
    consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos);
    session_destroy();
    die(error_page("Gestión de Guardias", "<p>" . $obj->error . "</p>"));
}
if (isset($obj->no_auth)) {
    consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos);
    session_unset();
    $_SESSION["mensaje"] = "El tiempo de sesión de la API ha expirado";
    header("Location:index.php");
    exit();
}
if (isset($obj->mensaje)) {
    consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos);
    session_unset();
    $_SESSION["mensaje"] = "Usted ha sido baneado de la base de datos.";
    header("Location:index.php");
    exit();
}

$datos_usu_log = $obj->usuario;

if (time() - $_SESSION["ultima_accion"] > MINUTOS * 60) {
    consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos);
    session_unset();
    $_SESSION["mensaje"] = "Su tiempo de sesión ha expirado.";
    header("Location:index.php");
    exit();
}

$_SESSION["ultima_accion"] = time();

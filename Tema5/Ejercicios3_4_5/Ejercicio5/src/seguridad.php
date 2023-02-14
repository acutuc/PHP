<?php
define("MINUTOS", 5);

$datos_segur["usuario"] = $_SESSION["usuario"];
$datos_segur["clave"] = $_SESSION["clave"];
$datos_segur["api_session"] = $_SESSION["api_session"];
$url = DIR_SERV . "/logueado";
$respuesta = consumir_servicios_REST($url, "POST", $datos_segur);
$obj = json_decode($respuesta);

if (!$obj) {
    $datos_salir["api_session"] = $_SESSION["api_session"];
    $url = DIR_SERV . "/salir";
    $respuesta = consumir_servicios_REST($url, "POST", $datos_salir);
    session_destroy();
    die(error_page("Login SW", "Login SW", "<p>Error consumiendo el servicio: " . $url . "</p>" . $respuesta));
}


if (isset($obj->error)) {
    $datos_salir["api_session"] = $_SESSION["api_session"];
    $url = DIR_SERV . "/salir";
    $respuesta = consumir_servicios_REST($url, "POST", $datos_salir);
    session_destroy();
    die(error_page("Login SW", "Login SW", "<p>" . $obj->error . "</p>"));
}

if (isset($obj->no_login)) {
    session_unset();
    $_SESSION["seguridad"] = "El tiempo de sesión de la API ha expirado.";
    header("Location:index.php");
    exit;
}

//Si ha pasado el tiempo de sesión de la API.
if (isset($obj->mensaje)) {
    $datos_salir["api_session"] = $_SESSION["api_session"];
    $url = DIR_SERV . "/salir";
    $respuesta = consumir_servicios_REST($url, "POST", $datos_salir);
    session_unset();
    $_SESSION["seguridad"] = "Usted ya no se encuentra registrado en la BD";
    header("Location:index.php");
    exit;
} else {
    $datos_usuario_log = $obj->usuario;
}

if (time() - $_SESSION["ultimo_acceso"] > MINUTOS * 60) {
    $datos_salir["api_session"] = $_SESSION["api_session"];
    $url = DIR_SERV . "/salir";
    $respuesta = consumir_servicios_REST($url, "POST", $datos_salir);
    session_destroy();
    $_SESSION["seguridad"] = "Su tiempo de sesión ha expirado";
    header("Location:index.php");
    exit;
}

$_SESSION["ultimo_acceso"] = time();
?>
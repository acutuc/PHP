<?php
$url = DIR_SERV . "/login";
$key_session["api_session"] = $_SESSION["api_session"];
$respuesta = consumir_servicios_REST($url, "POST", $key_session);
$obj = json_decode($respuesta);
if (!$obj) {
    //Destruimos también la sesion de la API:
    $url = DIR_SERV . "/salir";
    consumir_servicios_REST($url, "POST", $key_session);

    session_destroy();
    die(error_page("Examen4 PHP", "<h1>Examen4 PHP</h1><p>Error consumiendo el servicio: " . $url . "</p>" . $respuesta));
}
if (isset($obj->error)) {
    //Destruimos también la sesion de la API:
    $url = DIR_SERV . "/salir";
    consumir_servicios_REST($url, "POST", $key_session);

    session_destroy();
    die(error_page("Examen4 PHP", "<h1>Examen4 PHP</h1><p>" . $obj->error . "</p>"));
}

//Error de no_login:
if (isset($obj->no_login)) {
    session_unset();
    $_SESSION["seguridad"] = "El tiempo de sesión de la API ha expirado";
    header("Location:index.php");
    exit;
}

if (isset($obj->usuario)) {
    if (time() - $_SESSION["ultimo_acceso"] > MINUTOS * 60) {
        //Destruimos también la sesion de la API:
        $url = DIR_SERV . "/salir";
        consumir_servicios_REST($url, "POST", $key_session);

        session_unset();
        $_SESSION["seguridad"] = "Su tiempo de sesión ha caducado. Vuelva a loguearse o registrarse";
        header("Location:index.php");
        exit;
    }

} else {
    //Destruimos también la sesion de la API:
    $url = DIR_SERV . "/salir";
    consumir_servicios_REST($url, "POST", $key_session);

    session_unset();
    $_SESSION["seguridad"] = "Zona restringida. Vuelva a loguearse o registrarse";
    header("Location:index.php");
    exit;
}

$_SESSION["ultimo_acceso"] = time();
$datos_usuario_log = $obj->usuario;

?>
<?php
$url = DIR_SERV . "/logueado";
$datos["api_session"] = $_SESSION["api_session"];
$respuesta = consumir_servicios_REST($url, "GET", $datos);
$obj = json_decode($respuesta);

if (!$obj) {
    session_destroy();
    die(error_page("Librería", $url));
}

if (isset($obj->error)) {
    session_destroy();
    die(error_page("Librería", $obj->error));
}

if (isset($obj->no_auth)) {
    //Hemos perdido el acceso a la api:
    session_unset();
    $_SESSION["seguridad"] = "El tiempo de sesión de la API ha expirado.";
    header("Location:" . $salto);
    exit();
}

if (isset($obj->mensaje)) {
    //Nos han baneado:
    session_unset();
    $_SESSION["seguridad"] = "Usted ya no se encuentra registrado en la BD.";
    header("Location:" . $salto);
    exit();
}

//Si pasamos el control de baneo, recogemos los datos del usuario:
$datos_usu_log = $obj->usuario;

//Control de tiempo de sesión:
if (time() - $_SESSION["ultima_accion"] > MINUTOS * 60) {
    session_unset();
    $_SESSION["seguridad"] = "El tiempo de sesión ha expirado";
    header("Location:" . $salto);
    exit();
}
//Sino, renovamos el tiempo:
$_SESSION["ultima_accion"] = time();

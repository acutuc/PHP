<?php

$datos["usuario"] = $_SESSION["usuario"];
$datos["clave"] = $_SESSION["clave"];

$url = DIR_SERV . "/login";
$respuesta = consumir_servicios_REST($url, "POST", $datos);
$obj = json_decode($respuesta);

if (!$obj) {

    session_destroy();
    die(error_page("Error !obj", "<h1>Error !obj</h1><p>Error al consumir el servicio: " . $url . "</p>" . $respuesta));
}

if (isset($obj->error)) {

    session_destroy();
    die(error_page("Error errores", "<h1>Error errores</h1><p>" . $obj->error . "</p>"));
}

if (isset($obj->usuario)) {

    if (time() - $_SESSION["ultimo_acceso"] > MINUTOS * 60) {

        session_unset();
        $_SESSION["seguridad"] = "Tiempo de sesión caducado";
        header("Location:index.php");
        exit;
    }

    $datos_usuario_logueado = $obj->usuario;
    $_SESSION["ultimo_acceso"] = time();
} else {

    session_unset();
    $_SESSION["seguridad"] = "Zona restringida";
    header("Location:index.php");
    exit;
}

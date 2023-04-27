<?php

define("MINUTOS", 5);

$url = DIR_SERV . "/login";
$datos_envio["usuario"] = $_SESSION["usuario"];
$datos_envio["clave"] = $_SESSION["clave"];
$respuesta = consumir_servicios_rest($url, "POST", $datos_envio);
$obj = json_decode($respuesta);

if (!$obj) {
    session_destroy();
    die(error_page("Práctica 3", "Práctica 3", "Error consumiendo el servicio: " . $url));
}

if (isset($obj->mensaje_error)) {
    session_destroy();
    die(error_page("Práctica 3", "Práctica 3", $obj->mensaje_error));
}

//Si obtenemos "mensaje", es que ya no existimos en la BD:
if (isset($obj->mensaje)) {
    session_unset();
    $_SESSION["seguridad"] = "Usted ya no se encuentra registrado en la BD";
    header("Location:index.php");
    exit();
}

//Si no hemos muerto hasta aquí, obtenemos los datos del usuario:
$datos_usuario_log = $obj->usuario;

if (time() - $_SESSION["ultimo_acceso"] > MINUTOS * 60) {
    session_unset();
    $_SESSION["seguridad"] = "Su tiempo de sesión ha expirado";
    header("Location:index.php");
    exit();
} else {
    //Renovamos el tiempo
    $_SESSION["ultimo_acceso"] = time();
}


?>
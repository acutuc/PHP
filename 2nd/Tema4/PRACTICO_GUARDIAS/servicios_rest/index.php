<?php

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app = new \Slim\App;



$app->get('/logueado', function ($request) {
    $token = $request->getParam("api_session");
    session_id($token);
    session_start();

    if (isset($_SESSION["usuario"])) {
        echo json_encode(logueado($_SESSION["usuario"], $_SESSION["clave"]));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "Usted no tiene permisos para consumir este servicio"));
    }
});

$app->post('/login', function ($request) {

    $usuario = $request->getParam("usuario");
    $clave = $request->getParam("clave");

    echo json_encode(login($usuario, $clave));
});

$app->post("/salir", function ($request) {

    $token = $request->getParam("api_session");
    session_id($token);
    session_start();
    session_destroy();

    echo json_encode(array("log_out" => "Sesión de la API finalizada."));
});

$app->get('/usuario/{id_usuario}', function ($request) {

    $token = $request->getParam("api_session");
    session_id($token);
    session_start();

    if (isset($_SESSION["usuario"])) {
        $id_usuario = $request->getAttribute("id_usuario");
        echo json_encode(obtener_datos_usuario($id_usuario));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "Usted no tiene permisos para consumir este servicio"));
    }
});

$app->get('/usuariosGuardia/{dia}/{hora}', function ($request) {

    $token = $request->getParam("api_session");
    session_id($token);
    session_start();

    if (isset($_SESSION["usuario"])) {
        $datos[] = $request->getAttribute("dia");
        $datos[] = $request->getAttribute("hora");

        echo json_encode(usuarios_guardia_dia_hora($datos));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "Usted no tiene permisos para consumir este servicio"));
    }
});




// Una vez creado servicios los pongo a disposición
$app->run();

<?php

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app = new \Slim\App;



$app->get('/conexion_PDO', function ($request) {

    echo json_encode(conexion_pdo());
});

$app->get('/conexion_MYSQLI', function ($request) {

    echo json_encode(conexion_mysqli());
});

$app->post('/login', function ($request) {

    $usuario = $request->getParam("usuario");
    $clave = $request->getParam("clave");

    echo json_encode(login($usuario, $clave));
});

$app->get('/logueado', function ($request) {

    $token = $request->getParam("api_session");
    session_id($token);
    session_start();

    if (isset($_SESSION["usuario"])) {

        echo json_encode(logueado($_SESSION["usuario"], $_SESSION["clave"]));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "Usted no tiene permisos para usar este servicio."));
    }
});

$app->post('/salir', function ($request) {

    session_id($request->getParam("api_session"));
    session_start();
    session_destroy();
    echo json_encode(array("log_out" => "Sesión de la API cerrada"));
});

$app->get('/usuario/{id_usuario}', function ($request) {

    $token = $request->getParam("api_session");
    session_id($token);
    session_start();

    if (isset($_SESSION["usuario"])) {
        
        echo json_encode(obtener_usuario($request->getAttribute("id_usuario")));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "Usted no tiene permisos para usar este servicio."));
    }
});

// Una vez creado servicios los pongo a disposición
$app->run();

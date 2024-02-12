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

    if (isset($_SESSION["tipo"])) {
        echo json_encode(logueado($_SESSION["usuario"], $_SESSION["clave"]));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "Usted no tiene permisos para usar este servicio."));
    }
});

$app->post('/salir', function ($request) {

    $token = $request->getParam("api_session");
    session_id($token);
    session_start();
    session_destroy();

    echo json_encode(array("log_out" => "Sesión cerrada"));
});

$app->get('/horario/{id_usuario}', function ($request) {

    echo json_encode(obtener_horario($request->getAttribute("id_usuario")));
});


// Una vez creado servicios los pongo a disposición
$app->run();

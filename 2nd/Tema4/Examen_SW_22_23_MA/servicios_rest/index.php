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

    $lector = $request->getParam("lector");
    $clave = $request->getParam("clave");

    echo json_encode(login($lector, md5($clave)));
});

$app->get('/logueado', function ($request) {

    $token = $request->getParam("api_session");

    session_id($token);
    session_start();

    if (isset($_SESSION["usuario"])) {
        echo json_encode(logueado($_SESSION["usuario"], $_SESSION["clave"]));
    } else {
    }

    echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
});

$app->post('/salir', function ($request) {

    session_id($request->getParam("api_session")); // Es lo mismo que pasar el $token

    session_start();
    session_destroy();

    echo json_encode(array("log_out" => "Cerrada sesión den la API"));
});

$app->get('/obtenerLibros', function () {

        echo json_encode(obtener_libros());
});

$app->post('/crearLibro', function ($request) {

    $token = $request->getParam("api_session");
    session_id($token);
    session_start();

    if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "admin") {
        $datos[] = $request->getParam("referencia");
        $datos[] = $request->getParam("titulo");
        $datos[] = $request->getParam("autor");
        $datos[] = $request->getParam("descripcion");
        $datos[] = $request->getParam("precio");
        echo json_encode(crear_libro($datos));
    } else {
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }
});

$app->put('/actualizarPortada/{referencia}', function ($request) {

    $token = $request->getParam("api_session");
    session_id($token);
    session_start();

    if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "admin") {
        $datos[] = $request->getParam("portada");
        $datos[] = $request->getAttribute("referencia");
        echo json_encode(actualizar_portada($datos));
    } else {
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }
});

$app->get('/repetido/{tabla}/{columna}/{valor}', function($request){

    $token = $request->getParam("api_session");
    session_id($token);
    session_start();

    if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "admin") {
        echo json_encode(repetido($request->getAttribute("tabla"), $request->getAttribute("columna"), $request->getAttribute("valor")));
    } else {
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }

});

// Una vez creado servicios los pongo a disposición
$app->run();

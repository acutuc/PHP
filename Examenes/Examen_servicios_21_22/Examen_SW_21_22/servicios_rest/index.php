<?php

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app = new \Slim\App;



$app->get('/conexion_PDO', function ($request) {

    echo json_encode(conexion_pdo(), JSON_FORCE_OBJECT);
});

$app->get('/conexion_MYSQLI', function ($request) {

    echo json_encode(conexion_mysqli(), JSON_FORCE_OBJECT);
});

$app->post('/salir', function ($request) {

    session_id($request->getParam("api_session"));
    session_start();
    session_destroy();
    echo json_encode(array("no_auth" => "No logueado en la API"));

});

$app->post('/login', function ($request) {

    $datos[] = $request->getParam("usuario");
    $datos[] = $request->getParam("clave");

    echo json_encode(login($datos));

});

$app->post('/logueado', function ($request) {

    session_id($request->getParam("api_session"));
    session_start();

    if (isset($_SESSION["tipo"])) {

        $datos[] = $_SESSION["usuario"];
        $datos[] = $_SESSION["clave"];
        echo json_encode(logueado($datos));

    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No logueado en la API"));
    }

});

$app->get('/horario/{id_usuario}', function ($request) {

    session_id($request->getParam("api_session"));
    session_start();

    if (isset($_SESSION["tipo"])) {

        echo json_encode(horario($request->getAttribute("id_usuario")));

    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No logueado en la API"));
    }

});

$app->get('/usuarios', function ($request) {

    session_id($request->getParam("api_session"));
    session_start();

    if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "admin") {

        echo json_encode(obtener_usuarios());

    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No logueado en la API"));
    }

});





// Una vez creado servicios los pongo a disposición
$app->run();
?>
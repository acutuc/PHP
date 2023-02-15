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

$app->post("/login", function ($request) {
    $datos[] = $request->getParam("usuario");
    $datos[] = $request->getParam("clave");

    echo json_encode(login($datos));
});

$app->post("/logueado", function ($request) {

    session_id($request->getParam("api_session"));
    session_start();
    //Si existe $_SESSION, es que está logueado:
    if (isset($_SESSION["tipo"])) {
        $datos[] = $_SESSION["usuario"];
        $datos[] = $_SESSION["clave"];

        echo json_encode(login($datos, false));
    } else {
        session_destroy();
        echo json_encode(array("no_login" => "No logueado en la API"));
    }

});

$app->post("/salir", function ($request) {

    session_id($request->getParam("api_session"));
    session_start();
    session_destroy();
    echo json_encode(array("logout" => "Cerrada API"));

});


//Ejercicio b):
$app->get("/horario/{id_usuario}", function ($request) {

    session_id($request->getParam("api_session"));
    session_start();
    if (isset($_SESSION["tipo"])) {
        echo json_encode(obtener_horario($request->getAttribute("id_usuario")));
    } else {
        session_destroy();
        echo json_encode(array("no_login" => "No logueado en la API"));
    }

});

// Una vez creado servicios los pongo a disposición
$app->run();
?>
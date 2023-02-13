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
    //Si está logueado:
    if (isset($_SESSION["tipo"])) {
        $datos[] = $request->getParam("usuario");
        $datos[] = $request->getParam("clave");

        echo json_encode(login($datos));
    } else {
        session_destroy();
        echo json_encode(array("no_login"=>"No loogueado en la API"));
    }

});

$app->post("/salir",function($request){

    session_id($request->getParam("api_session"));
    session_start();
    session_destroy();
    echo json_encode(array("logout"=>"Cerrada API"));

});

$app->get("/horario/{id_usuario}", function ($request) {

    $datos[] = $request->getParam("nombre");
    $datos[] = $request->getParam("usuario");
    $datos[] = $request->getParam("clave");

});

// Una vez creado servicios los pongo a disposición
$app->run();
?>
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

$app->post('/salir', function($request){
    session_id($request->getParam("api_session"));
    session_start();
    session_destroy();
    echo json_encode(array("logout" => "Saliendo de la API sesion"));

});

$app->post('/login', function($request){

    $datos[] = $request->getParam("usuario");
    $datos[] = $request->getParam("clave");

    echo json_encode(login($datos));

});

$app->post('/logueado', function($request){
    session_id($request->getParam("api_session"));
    session_start();

    if(isset($_SESSION["usuario"])){
        $datos[] = $_SESSION["usuario"];
        $datos[] = $_SESSION["clave"];

        echo json_encode(logueado($datos));
    }else{
        echo json_encode(array("no_auth" => "No tienes permisos para acceder a la API"));
    }
});



// Una vez creado servicios los pongo a disposición
$app->run();
?>
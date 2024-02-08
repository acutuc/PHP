<?php

//require de funciones
require "src/funciones_ctes.php";

//require
require __DIR__ . '/Slim/autoload.php';

//crear app
$app = new \Slim\App;

$app->post('/login', function ($request) {

    $usuario = $request->getParam("usuario");
    $clave = $request->getParam("clave");

    echo json_encode(login($usuario, $clave));
});

$app->get('/logueado', function ($request) {

    $api_token = $request->getParam("api_session");
    session_id($api_token);
    session_start();

    if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "admin") {
        echo json_encode(logueado($_SESSION["usuario"], $_SESSION["clave"]));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "Usted no tiene permisos para consumir la API"));
    }
});

$app->get('/salir', function($request){

    session_id($request->getParam("api_session"));
    session_start();
    session_destroy();

    echo json_encode(array("log_out"=>"Cerrada sesión de la API"));

});




// Una vez creado servicios los pongo a disposición
$app->run();

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

$app->post('/logueado', function ($request) {

    //Recogemos la sesion del request y la iniciamos:
    $api_key = $request->getParam("api_key");
    session_id($api_key);
    session_start();

    if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "admin") {
        echo json_encode(logueado($_SESSION["usuario"], $_SESSION["clave"]));
    } else {
        echo json_encode(array("no_login" => "No estás logueado"));
    }
});

// Una vez creado servicios los pongo a disposición
$app->run();

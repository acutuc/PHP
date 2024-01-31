<?php

//require de funciones
require "src/funciones_ctes.php";

//require
require __DIR__ . '/Slim/autoload.php';

//crear app
$app = new \Slim\App;

$app->post('/login', function($request){

    $usuario = $request->getParam("usuario");
    $clave = $request->getParam("clave");

    echo json_encode(login($usuario, $clave));

});

// Una vez creado servicios los pongo a disposición
$app->run();

<?php

//require de funciones
require "src/funciones_ctes.php";

//require
require __DIR__ . '/Slim/autoload.php';

//crear app
$app = new \Slim\App;

$app->post('/login', function ($request) {

    //Recogemos usuario y clave:
    $usuario = $request->getParam('usuario');
    $clave = $request->getParam('clave');

    //Siempre un json_encode de un array:
    echo json_encode(login($usuario, $clave));
});


// Una vez creado servicios los pongo a disposición
$app->run();

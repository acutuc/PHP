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


//d)
$app->get('/obtenerLibros', function ($request) {

    //Pedimos el id a $request y creamos la sesion:
    session_id($request->getParam('api_session'));
    session_start();

    echo json_encode(obtenerLibros());
});

// Una vez creado servicios los pongo a disposición
$app->run();
?>
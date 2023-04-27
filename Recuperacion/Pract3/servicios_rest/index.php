<?php
require "../src/funciones.php";

require __DIR__ . '/Slim/autoload.php';

$app = new \Slim\App;


$app->post('/login', function ($request) {

    $datos[] = $request->getParam("usuario");
    $datos[] = $request->getParam("clave");

    echo json_encode(login($datos));

});

$app->get('/obtenerUsuarios', function ($request) {

    echo json_encode(obtenerUsuarios());

});

// Una vez creado servicios los pongo a disposición
$app->run();
?>
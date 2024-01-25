<?php

//require de funciones
require "../src/funciones_ctes.php";

//require
require __DIR__ . '/Slim/autoload.php';

//crear app
$app = new \Slim\App;

$app->get('/productos', function () {

    echo json_encode(obtener_productos());
});

$app->get('/producto/{cod}', function ($request) {

    echo json_encode(obtener_producto($request->getAttribute('cod')));
});

$app->post('/producto/insertar', function ($request) {
    $datos[] = $request->getParam("cod");
    $datos[] = $request->getParam("nombre");
    $datos[] = $request->getParam("nombre_corto");
    $datos[] = $request->getParam("descripcion");
    $datos[] = $request->getParam("PVP");
    $datos[] = $request->getParam("familia");

    echo json_encode(insertar_producto($datos));
});

$app->put('/producto/actualizar/{cod}', function ($request) {

    $datos[] = $request->getParam("cod");
    $datos[] = $request->getParam("nombre");
    $datos[] = $request->getParam("nombre_corto");
    $datos[] = $request->getParam("descripcion");
    $datos[] = $request->getParam("PVP");

    //Cogemos el código por arriba:
    $datos[] = $request->getAttribute("cod");

    echo json_encode(actualizar_producto($datos));
});

$app->delete('/producto/borrar/{cod}', function ($request) {

    echo json_encode(borrar_producto($request->getAttribute("cod")));
});

$app->get('/familias', function () {

    echo json_encode(obtener_familias());
});

$app->get('/repetido/{tabla}/{columna}/{valor}', function ($request) {

    echo json_encode(repetido_insertar($request->getAttribute("tabla"), $request->getAttribute("columna"), $request->getAttribute("valor")));
});

$app->get('/repetido/{tabla}/{columna}/{valor}/{columna_id}/{valor_id}', function ($request) {

    echo json_encode(repetido_editar($request->getAttribute("tabla"), $request->getAttribute("columna"), $request->getAttribute("valor"), $request->getAttribute("columna_id"), $request->getAttribute("valor_id")));
});
// Una vez creado servicios los pongo a disposición
$app->run();

<?php

require __DIR__ . '/Slim/autoload.php';
require "src/bd_config.php";
require "src/funciones.php";

$app = new \Slim\App;

//Todos los productos (a):

$app->get('/productos', function () {
    echo json_encode(obtener_productos());

});

//Info de un producto en concreto (b):

$app->get('/producto/{cod}', function ($request) {
    //getAttribute ES PARA CUANDO QUEREMOS RECOGER DATOS POR ARRIBA (POR GET)
    echo json_encode(obtener_producto($request->getAttribute("cod")));

});

//Insertar un producto (c):

$app->post('/producto/insertar', function ($request) {
    //getParam ES PARA CUANDO QUEREMOS RECOGER DATOS POR ABAJO (POR POST)
    $datos[] = $request->getParam("cod");
    $datos[] = $request->getParam("nombre");
    $datos[] = $request->getParam("nombre_corto");
    $datos[] = $request->getParam("descripcion");
    $datos[] = $request->getParam("PVP");
    $datos[] = $request->getParam("familia");

    echo json_encode(insertar_producto($datos));
});


//Editar un producto (d):
//PONEMOS EL cod EN EL ÚLTIMO LUGAR, le ponemos getAttribute porque viene por arriba.
$app->put("/producto/actualizar/{cod}", function ($request) {
    $datos[] = $request->getParam("nombre");
    $datos[] = $request->getParam("nombre_corto");
    $datos[] = $request->getParam("descripcion");
    $datos[] = $request->getParam("PVP");
    $datos[] = $request->getParam("familia");
    $datos[] = $request->getAttribute("cod");

    echo json_encode(actualizar_producto($datos));
});

//Borrar un producto (e):
$app->delete("/producto/borrar/{cod}", function ($request) {
    echo json_encode(borrar_producto($request->getAttribute("cod")));
});

//Obtener todas las familias
$app->get('/familias', function () {

    //$datos["cod"]=$request->getParam('cod');
    echo json_encode(obtener_familias());

});

//Obtener la familia de un producto en concreto:
$app->get("/familia/{cod}", function ($request) {
    echo json_encode(obtener_familia($request->getAttribute("cod")));
});

//

$app->get("/repet_insert/{tabla}/{columna}/{valor}", function ($request) {
    $datos[] = $request->getAttribute("tabla");
    $datos[] = $request->getAttribute("columna");
    $datos[] = $request->getAttribute("valor");
    echo json_encode(repetido($request->getAttribute("tabla"), $request->getAttribute("columna"), $request->getAttribute("valor")));
});

//

$app->get("/repet_edit/{tabla}/{columna}/{valor}/{columna_clave}/{valor_clave}", function ($request) {
    echo json_encode(repetido($request->getAttribute('tabla'), $request->getAttribute('columna'), $request->getAttribute('valor'), $request->getAttribute('columna_clave'), $request->getAttribute('valor_clave')));
});
// Una vez creado servicios los pongo a disposición
$app->run();
?>
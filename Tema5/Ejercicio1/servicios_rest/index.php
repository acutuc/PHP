<?php

require __DIR__ . '/Slim/autoload.php';
require "src/bd_config.php";
require "src/funciones.php";

$app= new \Slim\App;

//Todos los productos (a):

$app->get('/productos',function(){

    //$datos["cod"]=$request->getParam('cod');
    echo json_encode(obtener_productos());

});

//Info de un producto en concreto (b):

$app->get('/producto/{cod}',function($request){

    //$datos["cod"]=$request->getParam('cod');
    echo json_encode(obtener_producto($request->getAttribute("cod")));

});

//Insertar un producto (c):

$app->put('producto/insertar', function () {
    echo json_encode(insertar_producto());
});

// Una vez creado servicios los pongo a disposición
$app->run();
?>
<?php
require "src/funciones.php";
require __DIR__ . '/Slim/autoload.php';

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");



$app= new \Slim\App;

$app->post('/login',function($request){
    
    $datos[]=$request->getParam("usuario");
    $datos[]=$request->getParam("clave");


    echo json_encode(login($datos));

});

$app->get('/obtener_productos',function(){

    echo json_encode(obtener_productos());
});

$app->post('/insertar_producto',function($request){

    $datos[]=$request->getParam("fecha_recepcion");
    $datos[]=$request->getParam("nombre_producto");
    $datos[]=$request->getParam("cantidad");
    $datos[]=$request->getParam("unidad_medida");
    $datos[]=$request->getParam("precio_unitario");
    $datos[]=$request->getParam("consumido");

    echo json_encode(insertar_producto($datos));
});

$app->get('/obtener_usuario/{id}',function($request){

    echo json_encode(obtener_usuario($request->getAttribute('id')));
});

$app->delete('/borrar_usuario/{id}',function($request){

    echo json_encode(borrar_usuario($request->getAttribute('id')));
});


$app->get('/repetido_reg/{columna}/{valor}',function($request){

    echo json_encode(repetido($request->getAttribute('columna'),$request->getAttribute('valor')));
});

$app->post('/insertar_usuario',function($request){

    $datos[]=$request->getParam("usuario");
    $datos[]=$request->getParam("clave");
    $datos[]=$request->getParam("nombre");
    $datos[]=$request->getParam("dni");
    $datos[]=$request->getParam("sexo");
    $datos[]=$request->getParam("subs");

    echo json_encode(insertar_usuario($datos));
});

$app->put('/cambiar_foto/{id}',function($request){

    echo json_encode(cambiar_foto($request->getAttribute('id'),$request->getParam('foto')));
});

// Una vez creado servicios los pongo a disposición
$app->run();
?>

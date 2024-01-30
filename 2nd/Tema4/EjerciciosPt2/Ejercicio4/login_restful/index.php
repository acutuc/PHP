<?php

//require de funciones
require "src/funciones_ctes.php";

//require
require __DIR__ . '/Slim/autoload.php';

//crear app
$app = new \Slim\App;

// a)
$app->get('/usuarios',function(){

    echo json_encode(obtener_usuarios());

});


// b)
$app->post('/crearUsuario', function($request){

    $datos[] = $request->getParam("nombre");
    $datos[] = $request->getParam("usuario");
    $datos[] = $request->getParam("clave");
    $datos[] = $request->getParam("email");

    echo json_decode(crear_usuario($datos));
});


// c)
$app->post('/login', function ($request) {

    //Recogemos usuario y clave:
    $usuario = $request->getParam('usuario');
    $clave = $request->getParam('clave');

    //Siempre un json_encode de un array:
    echo json_encode(login($usuario, $clave));
});


// d)
$app->put('/actualizarUsuario/{idUsuario}', function($request){

    $datos[] = $request->getParam("nombre");
    $datos[] = $request->getParam("usuario");
    $datos[] = $request->getParam("clave");
    $datos[] = $request->getParam("email"); 

    //El parámetro tiene que ser igual que el del url:
    $datos[] = $request->getAttribute("idUsuario");

    echo json_decode(actualizar_usuario($datos));
});


// e)
$app->delete('/borrarUsuario/{id_usuario}', function($request){

    echo json_decode(borrar_usuario($request->getAttribute("id_usuario")));
});


// Una vez creado servicios los pongo a disposición
$app->run();

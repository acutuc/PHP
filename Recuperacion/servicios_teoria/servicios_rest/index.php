<?php

require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;

//GET, obtener información:
$app->get('/saludo',function(){

    echo json_encode(array("Mensaje" => "Hola a todos"));

});

//Está recibiendo un parámetro:
$app->get('/saludo/{mensaje}', function($datos){

    echo json_encode(array("Mensaje" => $datos->getAttribute("mensaje")));//Aquí va lo mismo que en el parámetro de la ruta

});

$app->get('/saludo/{mensaje1}/{mensaje2}', function($datos){

    echo json_encode(array("Mensaje" => "Mensaje1: ".$datos->getAttribute("mensaje1").". Mensaje2: ".$datos->getAttribute("mensaje2")));

});


//POST, crear datos:
//Aquí mandamos datos por debajo:
$app->post('/nuevo_saludo', function($request){

    $datos[] = $request->getParam("mensaje1");
    $datos[] = $request->getParam("mensaje2");

    echo json_encode(array("Mensaje" => "Mensaje1: ".$datos[0].". Mensaje2: ".$datos[1]));

});



//PUT
//Pasamos un parámetro por abajo y otro por arriba
$app->put('/cambiar_saludo/{id}', function($request){

    echo json_encode(array("Mensaje" => "Actualizo el mensaje con id: ".$request->getAttribute("id")." al nuevo valor: ".$request->getParam("mensaje")));

});



//DELETE
$app->delete('/borrar_saludo/{id}', function($request){

    echo json_encode(array("Mensaje" => "Elimino el mensaje con id: ".$request->getAttribute("id")));

});

// Una vez creado servicios los pongo a disposición
$app->run();
?>
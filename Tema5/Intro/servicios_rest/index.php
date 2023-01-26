<?php

require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;

$app->get('/saludo/{codigo}',function($request){

    //$datos["cod"]=$request->getParam('cod');
    echo json_encode(array("mensaje"=> "Hola ".$request->getAttribute('codigo')) ,JSON_FORCE_OBJECT);

});

$app->get('/saludo',function(){

    //$datos["cod"]=$request->getParam('cod');
    echo json_encode(array("mensaje"=> "Hola a todos"), JSON_FORCE_OBJECT);

});

$app->post('/saludo',function($request){

    $nombre1=$request->getParam('datos1');
    $nombre2=$request->getParam('datos2');
    echo json_encode(array("mensaje"=> "Hola ".$nombre1." y ".$nombre2),JSON_FORCE_OBJECT);

});

// -------- DELETE: ----------//

$app->delete("/borrar_saludo/{id}", function ($request) {
    echo json_encode(array("mensaje" => "El saludo con ID: " . $request->getAttribute("id") . " ha sido borrado"), JSON_FORCE_OBJECT);
});

// -------- PUT: ----------//

$app->put("/modificar_saludo/{id}{saludo_nuevo}", function ($request) {
    echo json_encode(array("mensaje" => "El saludo con ID: " . $request->getAttribute("id") . " ha sido actualizado a: ".$request->getAttribute("saludo_nuevo")), JSON_FORCE_OBJECT);
});

// -------- PUT CON POST: ----------//

$app->put("/modificar_saludo/{id}", function ($request) {
    echo json_encode(array("mensaje" => "El saludo con ID: " . $request->getAttribute("id") . " ha sido actualizado a ".$request->getParam("saludo_nuevo")), JSON_FORCE_OBJECT);
});


// Una vez creado servicios los pongo a disposición
$app->run();
?>
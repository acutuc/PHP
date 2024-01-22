<?php

//require
require __DIR__ . '/Slim/autoload.php';

//crear app
$app= new \Slim\App;

//app
/*$app->get('/saludo/{codigo}',function($request){

    //$datos["cod"]=$request->getParam('cod');
    echo json_encode(array("mensaje"=> "Hola ".$request->getAttribute('codigo')) ,JSON_FORCE_OBJECT);

});*/
//$app->get()
//$app->post()
//$app->put()
//$app->delete()

$app->get('/saludo',function(){
    $respuesta["mensaje"]='Hola';
    echo json_encode($respuesta);
});

$app->get('/saludo/{nombre}', function($request){
    $valor_recibido=$request->getAttribute('nombre');
    $respuesta["mensaje"]='Hola '.$valor_recibido;
    echo json_encode($respuesta);
});

$app->post('/saludo',function($request){
    $valor_recibido=$request->getParam('nombre');
    $respuesta["mensaje"]='+ Hola '.$valor_recibido;
    echo json_encode($respuesta);
});

$app->delete('/borrar_saludo/{id}', function($request){
    $id_recibida=$request->getAttribute('id');
    $respuesta["mensaje"]="Se ha borrado el saludo con id: ".$id_recibida;
    echo json_encode($respuesta);
});

$app->put('/actualizar_saludo/{id}', function($request){
    $id_recibida=$request->getAttribute('id');
    $nuevo_nombre=$request->getParam('nombre');
    $respuesta["mensaje"]='Se ha editado '.$id_recibida.' por '.$nuevo_nombre;
    echo json_encode($respuesta);
});

// Una vez creado servicios los pongo a disposición
$app->run();
?>
<?php

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;

$app->post("/login", function($request){

    $datos[] = $request->getParam("usuario");
    $datos[] = $request->getParam("clave");

    echo json_encode(login($datos), JSON_FORCE_OBJECT);
});

$app->get("/horario/{id_usuario}", function($request){

    $datos[] = $request->getAttribute("id_usuario");

    echo json_encode(obtener_horario_usuario($datos), JSON_FORCE_OBJECT);
});

$app->get("/usuarios", function(){

    echo json_encode(obtener_usuarios(), JSON_FORCE_OBJECT);
});

$app->get("/grupos/{dia}/{hora}/{id_usuario}", function($request){

    $datos[] = $request->getAttribute("dia");
    $datos[] = $request->getAttribute("hora");
    $datos[] = $request->getAttribute("id_usuario");

    echo json_encode(obtener_grupos($datos), JSON_FORCE_OBJECT);
});

$app->get("/gruposLibres/{dia}/{hora}/{id_usuario}", function($request){

    $datos[] = $request->getAttribute("dia");
    $datos[] = $request->getAttribute("hora");
    $datos[] = $request->getAttribute("id_usuario");

    echo json_encode(obtener_grupos_libres($datos), JSON_FORCE_OBJECT);
});

// Una vez creado servicios los pongo a disposición
$app->run();
?>

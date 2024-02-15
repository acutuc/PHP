<?php

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;

$app->post('/login', function($request){
    
    $usuario = $request->getParam("usuario");
    $clave = $request->getParam("clave");

    echo json_encode(login($usuario, $clave));
});

$app->get('/logueado', function($request){

    $token = $request->getParam("api_session");
    session_id($token);
    session_start();

    if(isset($_SESSION["tipo"])){
        echo json_encode(logueado($_SESSION["usuario"], $_SESSION["clave"]));
    }else{
        session_destroy();
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
    }
});

$app->post('/salir', function($request){

    $token = $request->getParam("api_session");
    session_id($token);
    session_start();
    session_destroy();

    echo json_encode(array("log_out"=>"Cerrada sesión de la API."));
});

$app->get('/alumnos', function($request){

    $token = $request->getParam("api_session");
    session_id($token);
    session_start();

    if(isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "tutor"){
        echo json_encode(obtener_datos_alumnos());
    }else{
        session_destroy();
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
    }

});

$app->get('/notasAlumno/{cod_alu}', function($request){

    $token = $request->getParam("api_session");
    session_id($token);
    session_start();

    if(isset($_SESSION["tipo"])){
        $datos[] = $request->getAttribute("cod_alu");
        echo json_encode(notas_alumno($datos));
    }else{
        session_destroy();
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
    }
});

$app->get('/NotasNoEvalAlumno/{cod_alu}', function($request){

    $token = $request->getParam("api_session");
    session_id($token);
    session_start();

    if(isset($_SESSION["tipo"])){
        $datos[] = $request->getAttribute("cod_alu");
        echo json_encode(notas_no_eval_alumno($datos));
    }else{
        session_destroy();
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
    }
});

$app->delete('/quitarNota/{cod_alu}', function($request){

    $token = $request->getParam("api_session");
    session_id($token);
    session_start();

    if(isset($_SESSION["tipo"])){
        $datos[] = $request->getParam("cod_asig");
        $datos[] = $request->getAttribute("cod_alu");
        echo json_encode(quitar_nota($datos));
    }else{
        session_destroy();
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
    }
});

$app->post('/ponerNota/{cod_alu}', function($request){
    $token = $request->getParam("api_session");
    session_id($token);
    session_start();

    if(isset($_SESSION["tipo"])){
        $datos[] = $request->getParam("cod_asig");
        $datos[] = $request->getAttribute("cod_alu");
        echo json_encode(poner_nota($datos));
    }else{
        session_destroy();
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
    }
});

$app->put('/cambiarNota/{cod_alu}', function($request){

    $token = $request->getParam("api_session");
    session_id($token);
    session_start();

    if(isset($_SESSION["tipo"])){
        $datos[] = $request->getParam("nota");
        $datos[] = $request->getParam("cod_asig");
        $datos[] = $request->getAttribute("cod_alu");
        echo json_encode(cambiar_nota($datos));
    }else{
        session_destroy();
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
    }

});

// Una vez creado servicios los pongo a disposición
$app->run();
?>

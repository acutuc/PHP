<?php

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;

$app->post('/salir',function($request){

    session_id($request->getParam('api_session'));
    session_start();
    session_destroy();
    echo json_encode(array("logout"=>"Cerrada API"));
});


$app->post('/logueado',function($request){

    session_id($request->getParam('api_session'));
    session_start();
    if(isset($_SESSION["tipo"]))
    {

        $datos[]=$_SESSION['usuario'];
        $datos[]=$_SESSION['clave'];
        echo json_encode(logueado($datos));
    }
    else
    {
        session_destroy();
        echo json_encode(array("no_login"=>"No logueado en la API"));
    }

});


$app->post('/login',function($request){

    $datos[]=$request->getParam('usuario');
    $datos[]=$request->getParam('clave');
    echo json_encode(login($datos));

});

$app->get('/obtenerHorarios/{id_usuario}', function($request){

    session_id($request->getParam("api_session"));
    session_start();

    if(isset($_SESSION["usuario"])){
        echo json_encode(obtenerHorarios($request->getAttribute("id_usuario")));
    }else{
        session_destroy();
        echo json_encode(array("no_login" => "No logueado en la API"));
    }

});

$app->get('/obtenerHorariosDia/{dia}', function($request){

    session_id($request->getParam("api_session"));
    session_start();

    if(isset($_SESSION["usuario"])){
        echo json_encode(obtenerHorarios($request->getAttribute("dia")));
    }else{
        session_destroy();
        echo json_encode(array("no_login" => "No logueado en la API"));
    }

});



// Una vez creado servicios los pongo a disposición
$app->run();
?>

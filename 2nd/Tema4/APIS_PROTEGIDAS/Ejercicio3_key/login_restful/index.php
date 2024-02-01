<?php
require "src/funciones_ctes.php";


require __DIR__ . '/Slim/autoload.php';

$app = new \Slim\App;

//El login siempre nos va a pedir sólo usuario y clave.
$app->post('/login', function ($request) {

    $usuario = $request->getParam('usuario');
    $clave = $request->getParam('clave');

    echo json_encode(login($usuario, $clave));
});

//Recibirá por debajo el token
$app->post('/logueado', function ($request) {

    $api_key = $request->getparam("api_key");

    //Ahora empezamos las sesiones con la id de login.
    session_id($api_key);
    session_start();

    //Si tenemos $_SESSION, es que estamos logueados, sino devolvemos un json diciendo que no:
    if (isset($_SESSION["usuario"])) {
        echo json_encode(logueado($_SESSION["usuario"], $_SESSION["clave"]));
    } else {
        session_destroy();
        echo json_encode(array("no_login" => "No logueado"));
    }
});

//Creamos el servicio para salir:
$app->post('/salir', function($request){

    //Entramos a la sesión y la destruimos
    session_id($request->getParam("api_key"));
    session_start();
    session_destroy();
    echo json_encode(array("logout"=>"Close session"));

});

//PROTEGEMOS LOS DEMÁS SERVICIOS PARA QUE LOS USEN SOLO LOS ADMINISTRADORES: 
$app->get('/usuarios', function ($request) {

    $api_key = $request->getparam("api_key");
    session_id($api_key);
    session_start();

    if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "admin") {
        echo json_encode(obtener_usuarios());
    } else {
        session_destroy();
        echo json_encode(array("no_login" => "No tienes permisos para usar este servicio."));
    }
});

$app->get('/usuario/{id_usuario}', function ($request) {
    $api_key = $request->getparam("api_key");
    session_id($api_key);
    session_start();

    if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "admin") {
        echo json_encode(obtener_usuario($request->getAttribute("id_usuario")));
    } else {
        session_destroy();
        echo json_encode(array("no_login" => "No tienes permisos para usar este servicio."));
    }
});

$app->post('/crearUsuario', function ($request) {

    $api_key = $request->getparam("api_key");
    session_id($api_key);
    session_start();

    if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "admin") {
        $datos[] = $request->getParam('nombre');
        $datos[] = $request->getParam('usuario');
        $datos[] = $request->getParam('clave');
        $datos[] = $request->getParam('email');

        echo json_encode(insertar_usuario($datos));
    } else {
        session_destroy();
        echo json_encode(array("no_login" => "No tienes permisos para usar este servicio."));
    }
});

$app->put('/actualizarUsuario/{id_usuario}', function ($request) {

    $api_key = $request->getparam("api_key");
    session_id($api_key);
    session_start();

    if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "admin") {
        $datos[] = $request->getParam('nombre');
        $datos[] = $request->getParam('usuario');
        $datos[] = $request->getParam('clave');
        $datos[] = $request->getParam('email');
        $datos[] = $request->getAttribute('id_usuario');

        echo json_encode(actualizar_usuario($datos));
    } else {
        session_destroy();
        echo json_encode(array("no_login" => "No tienes permisos para usar este servicio."));
    }
});

$app->put('/actualizarUsuarioSinClave/{id_usuario}', function ($request) {
    $api_key = $request->getparam("api_key");
    session_id($api_key);
    session_start();

    if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "admin") {
        $datos[] = $request->getParam('nombre');
        $datos[] = $request->getParam('usuario');
        $datos[] = $request->getParam('email');
        $datos[] = $request->getAttribute('id_usuario');

        echo json_encode(actualizar_usuario_sin_clave($datos));
    } else {
        session_destroy();
        echo json_encode(array("no_login" => "No tienes permisos para usar este servicio."));
    }
});

$app->delete('/borrarUsuario/{id_usuario}', function ($request) {
    $api_key = $request->getparam("api_key");
    session_id($api_key);
    session_start();

    if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "admin") {
        echo json_encode(borrar_usuario($request->getAttribute('id_usuario')));
    } else {
        session_destroy();
        echo json_encode(array("no_login" => "No tienes permisos para usar este servicio."));
    }
});

$app->get('/repetido/{tabla}/{columna}/{valor}', function ($request) {

    $api_key = $request->getparam("api_key");
    session_id($api_key);
    session_start();

    if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "admin") {
        echo json_encode(repetido($request->getAttribute('tabla'), $request->getAttribute('columna'), $request->getAttribute('valor')));
    } else {
        session_destroy();
        echo json_encode(array("no_login" => "No tienes permisos para usar este servicio."));
    }
});

$app->get('/repetido/{tabla}/{columna}/{valor}/{columna_id}/{valor_id}', function ($request) {

    $api_key = $request->getparam("api_key");
    session_id($api_key);
    session_start();

    if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "admin") {
        echo json_encode(repetido($request->getAttribute('tabla'), $request->getAttribute('columna'), $request->getAttribute('valor'), $request->getAttribute('columna_id'), $request->getAttribute('valor_id')));
    } else {
        session_destroy();
        echo json_encode(array("no_login" => "No tienes permisos para usar este servicio."));
    }
});


$app->run();

<?php

require __DIR__ . '/Slim/autoload.php';

require "src/funciones.php";

$app = new \Slim\App;

$app->get('/usuarios', function () {

    echo json_encode(obtener_usuarios());

});

$app->post('/salir', function ($request) {

    session_id($request->getParam('api_session'));
    session_start();
    session_destroy();
    echo json_encode(array("logout" => "Close sesion"));

});

$app->post('/logueado', function ($request) {

    session_id($request->getParam('api_session'));
    session_start();
    if (isset($_SESSION["tipo"])) {
        $datos[] = $_SESSION["usuario"];
        $datos[] = $_SESSION["clave"];
        
        echo json_encode(login($datos, false));
    } else {
        session_destroy();
        echo json_encode(array("no_login" => "No logueado"));
    }
});

$app->post('/crearUsuario', function ($request) {

    $datos[] = $request->getParam('nombre');
    $datos[] = $request->getParam('usuario');
    $datos[] = $request->getParam('clave');
    $datos[] = $request->getParam('email');

    echo json_encode(insertar_usuario($datos));

});

$app->post('/login', function ($request) {

    $datos[] = $request->getParam('usuario');
    $datos[] = $request->getParam('clave');

    echo json_encode(login($datos));

});

$app->put('/actualizarUsuario/{id_usuario}', function ($request) {

    $datos[] = $request->getParam('nombre');
    $datos[] = $request->getParam('usuario');
    $datos[] = $request->getParam('clave');
    $datos[] = $request->getParam('email');
    $datos[] = $request->getAttribute('id_usuario');

    echo json_encode(actualizar_usuario($datos));
});

$app->delete('/borrarUsuario/{id_usuario}', function ($request) {

    echo json_encode(borrar_usuario($request->getAttribute('id_usuario')));

});


$app->get('/repetido_insert/{tabla}/{columna}/{valor}', function ($request) {

    echo json_encode(repetido($request->getAttribute('tabla'), $request->getAttribute('columna'), $request->getAttribute('valor')));

});

$app->get('/repetido_edit/{tabla}/{columna}/{valor}/{columna_clave}/{valor_clave}', function ($request) {


    echo json_encode(repetido($request->getAttribute('tabla'), $request->getAttribute('columna'), $request->getAttribute('valor'), $request->getAttribute('columna_clave'), $request->getAttribute('valor_clave')));

});

// Una vez creado servicios los pongo a disposición
$app->run();
?>
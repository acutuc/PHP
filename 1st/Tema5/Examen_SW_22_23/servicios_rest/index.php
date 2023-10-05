<?php

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app = new \Slim\App;



$app->get('/conexion_PDO', function ($request) {

    echo json_encode(conexion_pdo());
});

$app->get('/conexion_MYSQLI', function ($request) {

    echo json_encode(conexion_mysqli());
});

$app->post('/login', function ($request) {

    $datos[] = $request->getParam("lector");
    $datos[] = md5($request->getParam("clave"));

    echo json_encode(login($datos));

    /*session_id($request->getParam("api_session"));
    session_start();
    if(isset($_SESSION["tipo"])){
    $datos[] = $request->getParam("lector");
    $datos[] = md5($request->getParam("clave"));
    echo json_encode(login($datos));
    }else{
    session_destroy();
    echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
    }*/
    
});

$app->get('/obtenerLibros', function ($request) {

    session_id($request->getParam("api_session"));
    session_start();
    if (isset($_SESSION["tipo"])) {
        echo json_encode(obtener_libros());
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }

});

$app->post('/crearLibro', function ($request) {

    session_id($request->getParam("api_session"));
    session_start();

    if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "admin") {
        $datos[] = $request->getParam("referencia");
        $datos[] = $request->getParam("titulo");
        $datos[] = $request->getParam("autor");
        $datos[] = $request->getParam("descripcion");
        $datos[] = $request->getParam("precio");

        echo json_encode(crear_libro($datos));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }

});

// Una vez creado servicios los pongo a disposición
$app->run();
?>
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

    $datos[] = $request->getParam("usuario");
    $datos[] = $request->getParam("clave");

    echo json_encode(login($datos));

});

$app->post('/logueado', function ($request) {

    //Recogemos la sesión de nuestro programa:
    session_id($request->getParam("api_session"));

    //Iniciamos sesión en el servidor:
    session_start();

    if (isset($_SESSION["usuario"])) {
        $datos[] = $_SESSION["usuario"];
        $datos[] = $_SESSION["clave"];
        echo json_encode(logueado($datos));
    } else {
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }

});

$app->post("/salir", function ($request) {

    //Recogemos la sesión de nuestro programa:
    session_id($request->getParam("api_session"));

    //Iniciamos sesión en el servidor:
    session_start();

    //Destruimos sesion y devolvemos un json:
    session_destroy();
    echo json_encode(array("log_out" => "Cerrada sesión de la API"));

});

$app->get("/usuario/{id_usuario}", function ($request) {

    session_id($request->getParam("api_session"));
    session_start();

    if (isset($_SESSION["api_session"])) {
        //Pasamos el valor del id de usuario por arriba. TIENEN QUE TENER LOS MISMOS CARACTERES:
        echo json_encode(obtener_usuario($request->getAttribute("id_usuario")));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }

});

$app->get("/usuariosGuardia/{dia}/{hora}", function($request){

    session_id($request->getParam("api_session"));
    session_start();

    if(isset($_SESSION["usuario"])){
        $datos[] = $request->getAttribute("dia");
        $datos[] = $request->getAttribute("hora");

        echo json_encode(obtener_usuarios($datos));
    }else{
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }

});



// Una vez creado servicios los pongo a disposición
$app->run();
?>
<?php

require __DIR__ . '/Slim/autoload.php';

$app = new \Slim\App;

function login($datos)
{
    try {
        $conexion = $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try{
            $consulta = "SELECT * FROM usuarios WHERE usuario = ? AND clave = ?";
            
            $sentencia = $conexion->prepare($consulta);

            $sentencia->execute($datos);
            if($sentencia->rowCount() > 0){
                
            }else{
                $respuesta["mensaje"] = "Usuario no se encuentra en la BD";
            }         
        }catch(PDOException $e){
            $respuesta["mensaje_error"] = "Imposible conectar. Error: ".$e->getMessage();
        }
    } catch (PDOException $e) {
        $respuesta["mensaje_error"] = "Imposible conectar. Error: " . $e->getMessage();
    }
    return $respuesta;
}

$app->get('/login', function ($request) {

    $datos[] = $request->getParam("usuario");
    $datos[] = $request->getParam("clave");

    echo json_encode(login($datos));

});

// Una vez creado servicios los pongo a disposición
$app->run();
?>
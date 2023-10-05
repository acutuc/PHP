<?php
define("SERVIDOR_BD", "localhost");
define("USUARIO_BD", "jose");
define("CLAVE_BD", "josefa");
define("NOMBRE_BD", "bd_blog");

//FUNCIONES:
function error_page($title, $encabezado, $mensaje)
{
    return '<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>' . $title . '</title>
    </head>
    <body>
        <h1>' . $encabezado . '</h1>
        ' . $mensaje . '
    </body>
    </html>';
}

function ejecutar_consulta(string $consulta, ?array $array = [])
{
    $sentencia = false;

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD);

        if (count($array) > 0) {
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($array);
        } else {
            $sentencia = $conexion->query($consulta);
        }
    } catch (PDOException $e) {
        error_page("Blog Personal", "Blog Personal", "Imposible conectar. Error: " . $e->getMessage());
    }

    return $sentencia;
}
?>
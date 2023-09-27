<?php
function bien_escrito($texto)
{
    $dni = strtoupper($texto);
    return strlen($dni) == 9 && is_numeric(substr($dni, 0, 8)) && substr($dni, 8, 1) >= "A" && substr($dni, 8, 1) <= "Z";
}

function error_page($titulo, $encabezado, $cuerpo)
{
    ?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>
            <?php $titulo ?>
        </title>
    </head>

    <body>
        <h1>
            <?php $encabezado ?>
        </h1>
        <p>
            <?php $cuerpo ?>
        </p>
    </body>

    </html>
    <?php
}

//Con esta función, comprobamos que un usuario al registrarse, no esté repetido en la BD:
function repetido_reg($columna, $valor)
{
    //Conectamos con la BD:
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        die(error_page("Práctica Rec 2", "Práctica Rec 2", "Imposible conectar. Error: " . $e->getMessage()));
    }
    //Consultamos:
    try {
        $consulta = "SELECT * FROM usuarios WHERE " . $columna . " = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$valor]);

        /*if($sentencia->rowCount() > 0){
        $respuesta = true;
        }else{
        $respuesta = false;
        }*/

        //1ª asignación a $respuesta:
        $respuesta = $sentencia->rowCount() > 0;

        $sentencia = null;
        $conexion = null;
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        //2ª asignación a $respuesta:
        $respuesta = "Imposible realizar la consulta. Error:" . $e->getMessage();
    }

    return $respuesta;
}
?>
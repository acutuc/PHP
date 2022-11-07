<!DOCTYPE html>
<html lang="es">

<head>
    <title>Teoría Acceso a BD</title>
    <meta charset="UTF-8">
</head>

<body>
    <?php
    //Servidor, usuario, contraseña, BBDD.
    mysqli_report(MYSQLI_REPORT_OFF); //Desactiva los fatal error.
    @$conexion = mysqli_connect("localhost", "jose", "josefa", "bd_teoria");
    mysqli_set_charset($conexion, "utf8"); //Caracteres UTF-8

    if (!$conexion) {
        die("Imposible conectar. Error nº: " . mysqli_connect_errno() . ". " . mysqli_connect_error());
    }

    $consulta = "SELECT * FROM t_alumnos";
    
    try{
        $resultado = mysqli_query($conexion, $consulta);

        //Podría obtener o no tuplas al hacer un SELECT.

        //mysqli_free_result se debe ejecutar siempre después de cada SELECT.
        mysqli_free_result($resultado);
        mysqli_close($conexion);
    }catch (Exception $e){
        $mensaje = "Imposible conectar. Error nº: ".mysqli_errno($conexion).". ".mysqli_error($conexion);
        mysqli_close($conexion);
        die($mensaje);
    }

    /*if($resultado){
        echo "bien";
    }else{
        echo "mal";
    }*/

    ?>
</body>

</html>
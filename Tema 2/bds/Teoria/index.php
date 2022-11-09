<!DOCTYPE html>
<html lang="es">

<head>
    <title>Teoría Acceso a BD</title>
    <meta charset="UTF-8">
    <style>
        table, th, td {border: 1px solid black}
        table {width:80%;margin:0 auto;border-collapse:collapse;text-align:center}
    </style>
</head>

<body>
    <?php
    try {
        mysqli_report(MYSQLI_REPORT_OFF); //Desactiva los fatal error.

        //Servidor, usuario, contraseña, BBDD.
        @$conexion = mysqli_connect("localhost", "jose", "josefa", "bd_teoria");
        mysqli_set_charset($conexion, "utf8"); //Caracteres UTF-8
    } catch (Exception $e) {
        die("Imposible conectar. Error nº: " . mysqli_connect_errno() . ". " . mysqli_connect_error());
    }

    $consulta = "SELECT * FROM t_alumnos";

    try {
        $resultado = mysqli_query($conexion, $consulta);

        echo "<p>Número de tuplas obtenidas: <strong>".mysqli_num_rows($resultado)."</strong></p>";
        //Obtiene una a una las tuplas obtenidas. Guarda un array:
        //Por cada posición del array, guarda los datos de una fila. Array ( [0] => 1 [1] => JAVIER PARODIO [2] => 666666666 [3] => 29680 )
        $tupla = mysqli_fetch_row($resultado);
        print_r($tupla);
        echo "<p><strong>Nombre: </strong>".$tupla[1]."</p>";

        //PARA ACCEDER MEDIANTE UN ARRAY ASOCIATIVO: Array ( [cod_alu] => 2 [nombre] => GABRIEL ALLENDE [telefono] => 607666356 [cp] => 29680 )
        $tupla = mysqli_fetch_assoc($resultado);
        print_r($tupla);
        echo "<p><strong>Nombre: </strong>".$tupla["nombre"]."</p>";

        //PARA ACCEDER MEDIANTE UN ARRAY ESCALAR O ASOCIATIVO: Array ( [0] => 3 [cod_alu] => 3 [1] => NO ES PERSONA [nombre] => NO ES PERSONA [2] => 999999999 [telefono] => 999999999 [3] => 12345 [cp] => 12345 )
        $tupla = mysqli_fetch_array($resultado);
        print_r($tupla);
        echo "<p><strong>Nombre: </strong>".$tupla["nombre"]."</p>";
        echo "<p><strong>Nombre: </strong>".$tupla[1]."</p>";

        //PARA OBJETOS: stdClass Object ( [cod_alu] => 4 [nombre] => CRISTINA [telefono] => 555555555 [cp] => 35014 )
        $tupla = mysqli_fetch_object($resultado);
        print_r($tupla);
        echo "<p><strong>Nombre: </strong>".$tupla->nombre."</p>";

        //Para volver el puntero al principio (el segundo parámetro es a qué tupla queremos ir):
        mysqli_data_seek($resultado, 0);

        //PARA RECORRER LAS TUPLAS:
        echo "<table>";
        echo "<tr><th>cod_alum</th><th>Nombre</th><th>Teléfono</th><th>Código Postal</th></tr>";
        while($tupla = mysqli_fetch_assoc($resultado)){
            echo "<tr>";
            echo "<td>".$tupla["cod_alu"]."</td>";
            echo "<td>".$tupla["nombre"]."</td>";
            echo "<td>".$tupla["telefono"]."</td>";
            echo "<td>".$tupla["cp"]."</td>";
            echo "</tr>";
        }
        echo "</table>";

        //Podría obtener o no tuplas al hacer un SELECT.

        //mysqli_free_result se debe ejecutar siempre después de cada SELECT, libera espacio.
        mysqli_free_result($resultado);

        //Cerramos conexion:
        mysqli_close($conexion);
    } catch (Exception $e) {
        $mensaje = "<p>Imposible conectar. Error nº: " . mysqli_errno($conexion) . ". " . mysqli_error($conexion)."</p>";
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
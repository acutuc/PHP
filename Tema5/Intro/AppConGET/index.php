<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoría Servicios Web</title>
</head>

<body>
    <h1>Teoría Servicios Web</h1>
    <?php
    $url = "http://dwese.icarosproject.com/Guardias/guardias_rest/grupos/1";

    //Método para hacer llamadas remota a GET:
    @$respuesta = file_get_contents($url);
    //En $respuesta almacenamos un string JSON.
    
    //Hay un método de php que decodifica el JSON obtenido:
    $obj = json_decode($respuesta);
    //Si no tenemos error:
    if (!$obj) {
        die("<p>Error consumiendo el servicio: ".$url."</p>".$respuesta);
    }

    //Recorremos el objeto:
    echo "<h2>Listado de los grupos del IES Mar de Alborán</h2>";
    echo "<table>";
    echo "<tr><th>#ID</th><th>Nombre</th></tr>";
    //Accedemos al índice con la flechita.
    foreach($obj->grupos as $grupos){
        echo "<tr>
            <td>".$grupos->id_grupo."</td>
            <td>".$grupos->nombre."</td>
        </tr>";
    }
    echo "</table>";
    ?>
</body>

</html>
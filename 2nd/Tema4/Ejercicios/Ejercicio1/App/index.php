<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        table {
            border: 1px solid black;
            border-collapse: collapse;
            margin: 0 auto;
        }

        th,
        td {
            border: 1px solid black;
        }
    </style>
    <title>TEORIA API</title>
</head>

<body>


    <?php
    define('DIR_SERV', "http://localhost/PHP/2nd/Tema4/Ejercicios/Ejercicio1/api/");

    //función consumir servicios
    function consumir_servicios_REST($url, $metodo, $datos = null)
    {
        $llamada = curl_init();
        curl_setopt($llamada, CURLOPT_URL, $url);
        curl_setopt($llamada, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($llamada, CURLOPT_CUSTOMREQUEST, $metodo);
        if (isset($datos))
            curl_setopt($llamada, CURLOPT_POSTFIELDS, http_build_query($datos));
        $respuesta = curl_exec($llamada);
        curl_close($llamada);
        return $respuesta;
    }

    //$datos["cod"]="NK2001";
    $datos["nombre"] = "Producto a borrar";
    $datos["nombre_corto"] = "Producto a borrar";
    $datos["descripcion"] = "Descripción a borrar";
    $datos["PVP"] = 50;
    $datos["familia"] = "MP3";


    $url = DIR_SERV . "/productos";
    $respuesta = consumir_servicios_REST($url, "GET");

    $obj = json_decode($respuesta);
    if (!$obj) {
        die("<p>Error consumiendo el servicio: " . $url . "</p>" . $respuesta);
    }

    if (isset($obj->mensaje_error)) {
        die("<p>" . $obj->mensaje_error . "</p>");
    }

    //Pintamos la tabla, con un foreach:
    echo "<table>";

    echo "<tr><th>Cod</th><th>Nombre corto</th></tr>";
    foreach ($obj->productos as $tupla) {
        echo "<tr>";

        echo "<td>" . $tupla->cod . "</td>";
        echo "<td>" . $tupla->nombre_corto . "</td>";


        echo "</tr>";
    }
    echo "</table>";
    echo "<p>El número de tuplas obtenidas ha sido de: ".count($obj->productos)."</p>";

    //Pintamos la tabla de un producto en concreto:
    $url = DIR_SERV . "/producto/KSTDTG332GBR";
    $respuesta = consumir_servicios_REST($url, "GET");

    $obj = json_decode($respuesta);
    if (!$obj) {
        die("<p>Error consumiendo el servicio: " . $url . "</p>" . $respuesta);
    }

    if (isset($obj->mensaje_error)) {
        die("<p>" . $obj->mensaje_error . "</p>");
    }

    echo "<h1>El nombre corto de KSTDTG332GBR es: ".$obj->producto->nombre_corto."</h1>";
    ?>

</body>

</html>
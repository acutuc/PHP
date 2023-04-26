<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoría</title>
</head>

<body>
    <h1>Llamamos a los servicios</h1>

    <?php
    //Dirección de ataque, metodo, y opcionalmente los datos
    function consumir_servicios_rest($url, $metodo, $datos = null)
    {
        $llamada = curl_init();
        curl_setopt($llamada, CURLOPT_URL, $url);
        curl_setopt($llamada, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($llamada, CURLOPT_CUSTOMREQUEST, $metodo);
        if (isset($datos)) {
            curl_setopt($llamada, CURLOPT_POSTFIELDS, http_build_query($datos));
        }
        $respuesta = curl_exec($llamada);
        curl_close($llamada);
        return $respuesta;
    }

    //Probamos a llamar el primer servicio:
    define("DIR_SERV", "http://localhost/PHP/Recuperacion/servicios_teoria/servicios_rest");
    $url = DIR_SERV . "/saludo";
    $respuesta = consumir_servicios_rest($url, "GET");

    $obj = json_decode($respuesta);

    //Si no recibimos un objeto:
    if (!$obj) {
        die("<p>Error consumiendo el servicio: " . $url . "</p>" . $respuesta);
    }

    //Si no muero, es que he podido decodificarlo. Puede ser el con el índice esperado o con el índice "error":
    echo "<p>" . $obj->Mensaje . "</p>";



    //Probamos a llamar el segundo servicio:
    //Utilizamos urlencode para los espacios
    $url = DIR_SERV . "/saludo/" . urlencode("Hola me llamo Juan") . "/" . urlencode("Hola me llamo Pepe");
    $respuesta = consumir_servicios_rest($url, "GET");

    $obj = json_decode($respuesta);

    //Si no recibimos un objeto:
    if (!$obj) {
        die("<p>Error consumiendo el servicio: " . $url . "</p>" . $respuesta);
    }

    //Si no muero, es que he podido decodificarlo. Puede ser el con el índice esperado o con el índice "error":
    echo "<p>" . $obj->Mensaje . "</p>";



    //Probamos a llamar el servicio POST:
    $url = DIR_SERV . "/nuevo_saludo";
    //PASAMOS EL ÍNDICE TAL Y COMO SE LLAMA EN LA API:
    $datos_envi["mensaje1"] = "Hola mensaje1 con POST";
    $datos_envi["mensaje2"] = "Hola mensaje2 con POST";

    //Consumimos el servicio, pasamos los datos como tercer parámetro:
    $respuesta = consumir_servicios_rest($url, "POST", $datos_envi);

    $obj = json_decode($respuesta);

    //Si no recibimos un objeto:
    if (!$obj) {
        die("<p>Error consumiendo el servicio: " . $url . "</p>" . $respuesta);
    }

    //Si no muero, es que he podido decodificarlo. Puede ser el con el índice esperado o con el índice "error":
    echo "<p>" . $obj->Mensaje . "</p>";



    //Probamos a llamar el servicio PUT:
    $url = DIR_SERV . "/cambiar_saludo/35";
    $datos_envi["mensaje"] = "Hola mensaje con PUT";

    //Consumimos el servicio, pasamos los datos como tercer parámetro:
    $respuesta = consumir_servicios_rest($url, "PUT", $datos_envi);

    $obj = json_decode($respuesta);

    //Si no recibimos un objeto:
    if (!$obj) {
        die("<p>Error consumiendo el servicio: " . $url . "</p>" . $respuesta);
    }

    //Si no muero, es que he podido decodificarlo. Puede ser el con el índice esperado o con el índice "error":
    echo "<p>" . $obj->Mensaje . "</p>";




    //Probamos a llamar el servicio DELETE:
    $url = DIR_SERV . "/borrar_saludo/35";

    //Consumimos el servicio:
    $respuesta = consumir_servicios_rest($url, "DELETE");

    $obj = json_decode($respuesta);

    //Si no recibimos un objeto:
    if (!$obj) {
        die("<p>Error consumiendo el servicio: " . $url . "</p>" . $respuesta);
    }

    //Si no muero, es que he podido decodificarlo. Puede ser el con el índice esperado o con el índice "error":
    echo "<p>" . $obj->Mensaje . "</p>";
    ?>
</body>

</html>
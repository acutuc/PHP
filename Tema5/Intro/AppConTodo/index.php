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

    define("DIR_SERV", "http://localhost/PHP/Tema5/Intro/servicios_rest");



    @$respuesta = file_get_contents(DIR_SERV . "/saludo");

    $obj = json_decode($respuesta);
    if (!$obj) {
        die("<p>Error consumiendo el servicio: " . DIR_SERV . "/saludo</p>" . $respuesta);
    }
    echo "<p>" . $obj->mensaje . "</p><hr>";

    /*---------------------------------------------*/

    //PARA LLAMAR A UN MÉTODO GET:
    
    //Iniciamos la llamada:
    $respuesta = consumir_servicios_rest(DIR_SERV . "/saludo/Juan", "GET");

    $obj = json_decode($respuesta);
    if (!$obj) {
        die("<p>Error consumiendo el servicio: " . DIR_SERV . "/saludo</p>" . $respuesta);
    }
    echo "<p>" . $obj->mensaje . "</p><hr>";

    /*---------------------------------------------*/

    //PARA LLAMAR A UN MÉTODO POST:
    
    $datos_post["datos1"] = "María";
    $datos_post["datos2"] = "Pedro Miguel";


    $respuesta = consumir_servicios_rest(DIR_SERV . "/saludo", "POST", $datos_post);

    $obj = json_decode($respuesta);

    echo "<p>" . $obj->mensaje . "</p><hr>";

    /*---------------------------------------------*/

    //PARA LLAMAR A UN MÉTODO DELETE:
    
    $respuesta = consumir_servicios_rest(DIR_SERV . "/borrar_saludo/3", "DELETE");

    $obj = json_decode($respuesta);
    if (!$obj) {
        die("<p>Error consumiendo el servicio: " . DIR_SERV . "/saludo</p>" . $respuesta);
    }
    echo "<p>" . $obj->mensaje . "</p><hr>";

    /*---------------------------------------------*/

    //PARA LLAMAR A UN MÉTODO PUT:
    
    $respuesta = consumir_servicios_rest(DIR_SERV . "/modificar_saludo/3/" . urlencode("nuevo saludo"), "PUT");

    $obj = json_decode($respuesta);
    if (!$obj) {
        die("<p>Error consumiendo el servicio: " . DIR_SERV . "/saludo</p>" . $respuesta);
    }
    echo "<p>" . $obj->mensaje . "</p><hr>";

    /*---------------------------------------------*/

    //PARA LLAMAR A UN MÉTODO PUT CON POST:
    
    $datos_put["saludo_nuevo"] = "Otro nuevo saludo";

    $respuesta = consumir_servicios_rest(DIR_SERV . "/modificar_saludo/3" . urlencode("nuevo saludo"), "PUT");

    $obj = json_decode($respuesta);
    if (!$obj) {
        die("<p>Error consumiendo el servicio: " . DIR_SERV . "/saludo</p>" . $respuesta);
    }
    echo "<p>" . $obj->mensaje . "</p><hr>";
    ?>
</body>

</html>
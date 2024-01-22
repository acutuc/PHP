<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TEORIA API</title>
</head>
<body>

    
    <?php
    define('DIR_SERV', "http://localhost/Proyectos/Semana_1_Enero/SERVICIOS_WEB/primera_api");

    //función consumir servicios
    function consumir_servicios_REST($url,$metodo,$datos=null){
        $llamada=curl_init();
        curl_setopt($llamada,CURLOPT_URL,$url);
        curl_setopt($llamada,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($llamada,CURLOPT_CUSTOMREQUEST,$metodo);
        if(isset($datos))
            curl_setopt($llamada,CURLOPT_POSTFIELDS,http_build_query($datos));
        $respuesta=curl_exec($llamada);
        curl_close($llamada);
        return $respuesta;
    }

    $url=DIR_SERV."/saludo/".urlencode("Juan José Bazán Espinosa");
    //$respuesta=file_get_contents($url);
    $respuesta=consumir_servicios_REST($url, "GET");
    $obj=json_decode($respuesta);
    if(!$obj){
        die("<p>Error consumiendo el serivicio: ".$url."</p>".$respuesta);
    } else {
        echo "<p>El saludo recibido ha sido <b>".$obj->mensaje."</b></p>";
    }

    $url=DIR_SERV."/saludo";
    $datos['nombre']="Juan José Bazán Espinosa";
    $respuesta=consumir_servicios_REST($url, "POST", $datos);
    $obj=json_decode($respuesta);
    if(!$obj){
        die("<p>Error consumiendo el serivicio: ".$url."</p>".$respuesta);
    } else {
        echo "<p>El saludo recibido ha sido <b>".$obj->mensaje."</b></p>";
    }

    $url=DIR_SERV."/borrar_saludo/5";
    //$respuesta=file_get_contents($url);
    $respuesta=consumir_servicios_REST($url, "DELETE");
    $obj=json_decode($respuesta);
    if(!$obj){
        die("<p>Error consumiendo el serivicio: ".$url."</p>".$respuesta);
    } else {
        echo "<p>El saludo recibido ha sido <b>".$obj->mensaje."</b></p>";
    }

    $url=DIR_SERV."/actualizar_saludo/8";
    //$respuesta=file_get_contents($url);
    $datos['nombre']="NK";
    $respuesta=consumir_servicios_REST($url, "PUT", $datos);
    $obj=json_decode($respuesta);
    if(!$obj){
        die("<p>Error consumiendo el serivicio: ".$url."</p>".$respuesta);
    } else {
        echo "<p>El saludo recibido ha sido <b>".$obj->mensaje."</b></p>";
    }

    ?>

</body>
</html>
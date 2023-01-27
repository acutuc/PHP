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

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 1</title>
</head>

<body>
    <h1>Listado de los productos</h1>
    <?php
    $url = "http://localhost/PHP/Tema5/Ejercicio1/servicios_rest/productos";
    $respuesta = consumir_servicios_rest($url, "GET");

    //a):
    
    $obj = json_decode($respuesta);
    if (!$obj) {
        die("<p>Error consumiendo el servicio rest: " . $url . "</p>" . $respuesta . "</body></html>");
    }

    //Si tenemos error:
    if (isset($obj->mensaje_error)) {
        die("<p>" . $obj->mensaje_error . "</p></body></html>");
    }

    //Si queremos ver cuántos elementos tenemos:
    echo "<p>Número de productos: " . count($obj->productos) . "</p>";

    //Listamos:
    echo "<table>";
    echo "<tr><th>COD</th><th>Nombre</th><th>PVP</th></tr>";
    foreach ($obj->productos as $tupla) {
        echo "<tr><td>".$tupla->cod."</td><td>" . $tupla->nombre_corto . "</td><td>" . $tupla->PVP . "</td></tr>";
    }
    echo "</table>";

    echo "<hr>";

    //b):
    
    $url = "http://localhost/PHP/Tema5/Ejercicio1/servicios_rest/producto/3DSNG";
    $respuesta = consumir_servicios_rest($url, "GET");

    $obj = json_decode($respuesta);
    if (!$obj) {
        die("<p>Error consumiendo el servicio rest: " . $url . "</p>" . $respuesta . "</body></html>");
    }

    if (isset($obj->mensaje_error)) {
        die("<p>" . $obj->mensaje_error . "</p></body></html>");
    }

    if (!$obj->producto) {
        echo "<p>El producto solicitado no se encuentra en la base de datos</p>";
    } else {
        echo "<p><strong>Nombre corto: </strong>" . $obj->producto->nombre_corto . "<hr></p>";
    }

    //c):

    //Aquí creamos el array asociativo que pasaremos luego por parámetro a la función consumir_servicios_rest():
    $datos_insert["cod"] = "ERTFRG";
    $datos_insert["nombre"] = "Plato de porcelana";
    $datos_insert["nombre_corto"] = "Plato";
    $datos_insert["descripcion"] = "Sorprende a tu familia con éste maravilloso plato.";
    $datos_insert["PVP"] = "10.00";
    $datos_insert["familia"] = "TV";
    
    $url = "http://localhost/PHP/Tema5/Ejercicio1/servicios_rest/producto/insertar";
    $respuesta = consumir_servicios_rest($url, "POST", $datos_insert);

    $obj = json_decode($respuesta);
    if (!$obj) {
        die("<p>Error consumiendo el servicio rest: " . $url . "</p>" . $respuesta . "</body></html>");
    }

    if (isset($obj->mensaje_error)) {
        die("<p>" . $obj->mensaje_error . "</p></body></html>");
    }else{
        echo "<p>El producto con código: ".$obj->mensaje." ha sido insertado con éxito<hr></p>";
    }


    //d):

    $datos_act["nombre"] = "Paraguas multicolor";
    $datos_act["nombre_corto"] = "Paraguas";
    $datos_act["descripcion"] = "Protégete de la lluvia";
    $datos_act["PVP"] = "50.00";
    $datos_act["familia"] = "TV";
    
    //Pasamos el código en la url
    $url = "http://localhost/PHP/Tema5/Ejercicio1/servicios_rest/producto/actualizar/ERTFRG";
    $respuesta = consumir_servicios_rest($url, "PUT", $datos_act);

    $obj = json_decode($respuesta);
    if (!$obj) {
        die("<p>Error consumiendo el servicio rest: " . $url . "</p>" . $respuesta . "</body></html>");
    }

    if (isset($obj->mensaje_error)) {
        die("<p>" . $obj->mensaje_error . "</p></body></html>");
    }else{
        echo "<p>El producto con código: ".$obj->mensaje." ha sido actualizado con éxito<hr></p>";
    }
    //e):
    //Pasamos el código en la url
    $url = "http://localhost/PHP/Tema5/Ejercicio1/servicios_rest/producto/borrar/ERTFRG";
    $respuesta = consumir_servicios_rest($url, "POST");

    $obj = json_decode($respuesta);
    if (!$obj) {
        die("<p>Error consumiendo el servicio rest: " . $url . "</p>" . $respuesta . "</body></html>");
    }

    if (isset($obj->mensaje_error)) {
        die("<p>" . $obj->mensaje_error . "</p></body></html>");
    }else{
        echo "<p>El producto con código: ".$obj->mensaje." ha sido actualizado con éxito<hr></p>";
    }
    ?>    
</body>

</html>
<?php
    require "src/funciones.php";

    define("DIR_SERV", "http://localhost/PHP/REACT/servicios_rest");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PROYECTO REACT</title>
    <style>
        td, th{
            padding:1rem;
            text-align: center;
        }
    </style>
</head>
<body>
    <h3>Listado de productos: </h3>
    <?php
        $url = DIR_SERV."/obtener_productos";
        $respuesta = consumir_servicios_REST($url, "GET");
        $obj = json_decode($respuesta);

        if(!$obj){
            die("<p>Error consumiendo el servicio: ".$url."</p></body></html>");
        }

        if(isset($obj->mensaje_error)){
            die("<p>".$obj->mensaje_error."</p></body></html>");
        }

        if(isset($obj->mensaje)){
            die("<p>".$obj->mensaje."</p></body></html>");
        }

        if(isset($obj->productos)){
            echo "<table>";
            echo "<tr>";
            echo "<th>id_producto</th><th>nombre_producto</th><th>cantidad</th><th>unidad_medida</th><th>precio_unitario</th><th>fecha_recepcion</th><th>id_almacen</th>";
            foreach($obj->productos as $tupla){
                echo "<tr>";

                echo "<td>".$tupla->id_producto."</td>";
                echo "<td>".$tupla->nombre_producto."</td>";
                echo "<td>".$tupla->cantidad."</td>";
                echo "<td>".$tupla->unidad_medida."</td>";
                echo "<td>".$tupla->precio_unitario."</td>";
                echo "<td>".$tupla->fecha_recepcion."</td>";
                echo "<td>".$tupla->id_almacen."</td>";

                echo "</tr>";
            }
            echo "</table>";
        }
    ?>
</body>
</html>
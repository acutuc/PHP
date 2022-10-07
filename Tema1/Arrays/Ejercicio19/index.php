<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 19</title>
</head>
<body>
    <h1>Ejercicio 19</h1>
    <p>Crea una matriz para guardar a los amigos clasificados por diferentes ciudades. Los valores serán los siguientes:</p>
    <p>En Madrid: nombre Pedro, edad 32, teléfono 91-999.99.99
        En Barcelona: nombre Susana, edad 34, teléfono 93-000.00.00
        En Toledo: nombre Sonia, edad 42, teléfono 925-09.09.09</p>
    <p>Haz un recorrido del array multidimensional mostrando los valores de tal manera que nos muerte en cada ciudad qué amigos tiene.</p>
    <?php
    $pedro = array("Edad"=>32, "Teléfono"=>"91-9999999");
    $antonio = array("Edad"=>45, "Teléfono"=>"01-9999999");
    $madrid = array("Pedro"=>$pedro, "Antonio"=>$antonio);

    $susana = array("Edad"=>28, "Teléfono"=>"91-0000000");
    $barcelona = array("Susana"=>$susana);

    $pepe = array("Edad"=>23, "Teléfono"=>"99-9999999");
    $maria = array("Edad"=>45, "Teléfono"=>"41-9999999");
    $toledo = array("Pepe"=>$pepe, "María"=>$maria);

    $amigos = array("Madrid"=>$madrid, "Barcelona"=>$barcelona, "Toledo"=>$toledo);    

    foreach($amigos as $ciudad => $valores){
        echo "<p>Amigos en ".$ciudad."</p>";
        echo "<ol>";
        foreach($valores as $nombre => $datos){
            echo "<li><strong>Nombre: </strong>".$nombre.". ";
            foreach($datos as $propiedad => $valor){
                echo "<strong>".$propiedad.": </strong>".$valor.". ";
            }
            echo "</li>";
        }
        echo "</ol>";
    }
    ?>
</body>
</html>
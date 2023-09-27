<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 7</title>
</head>

<body>
    <?php
    $arr = ["MD" => "Madrid", "BCN" => "Barcelona", "LON" => "Londres", "NY" => "Nueva York", "LA" => "Los Ángeles", "CHI" => "Chicago"];
    foreach($arr as $clave => $valor){
        echo "<p>El índice del array que contiene como valor ".$valor." es ".$clave."</p>";
    }
    ?>
</body>

</html>
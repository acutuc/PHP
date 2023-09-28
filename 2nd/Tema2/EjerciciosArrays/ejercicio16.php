<!DOCTYPE html>
<html lang="es">

<head>
    <title>Ejercicio 16</title>
    <meta charset="UTF-8">
</head>

<body>
    <?php
    $arr = array(5 => 1, 12 => 2, 13 => 56, "x" => 42);
    echo "<p>Número de elementos: " . count($arr) . "</p>";

    unset($arr[5]);
    print_r($arr);
    ?>
</body>

</html>
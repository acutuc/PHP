<!DOCTYPE html>
<html lang="es">

<head>
    <title>Ejercicio 13</title>
    <meta charset="UTF-8">
</head>

<body>
    <?php
    $arr1 = ["Lagartija", "Araña", "Perro", "Gato", "Ratón"];
    $arr2 = ["12", "34", "45", "52", "12"];
    $arr3 = ["Sauce", "Pino", "Naranjo", "Chopo", "Perro", "34"];

    $arr4 = array_merge($arr1, $arr2, $arr3);

    for ($i = count($arr4) - 1; $i > -1; $i--) {
        echo $arr4[$i] . " ";
    }
    ?>
</body>

</html>
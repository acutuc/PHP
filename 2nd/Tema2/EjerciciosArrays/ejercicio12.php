<!DOCTYPE html>
<html lang="es">

<head>
    <title>Ejercicio 12</title>
    <meta charset="UTF-8">
</head>

<body>
    <?php
    $arr1 = ["Lagartija", "Araña", "Perro", "Gato", "Ratón"];
    $arr2 = ["12", "34", "45", "52", "12"];
    $arr3 = ["Sauce", "Pino", "Naranjo", "Chopo", "Perro", "34"];

    $arr4 = array_merge($arr1, $arr2, $arr3);

    print_r($arr4);
    ?>
</body>

</html>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 6</title>
</head>

<body>
    <?php
    $arr = ["Madrid", "Barcelona", "Londres", "Nueva York", "Los Ángeles", "Chicago"];
    foreach ($arr as $clave => $valor) {
        echo "<p>La ciudad con el índice " . $clave . " tiene el nombre de " . $valor . "</p>";
    }
    ?>
</body>

</html>
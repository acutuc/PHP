<!DOCTYPE html>
<html lang="es">

<head>
    <title>Ejercicio 18</title>
    <meta charset="UTF-8">
</head>

<body>
    <?php
    $deportes = ["fútbol", "baloncesto", "natación", "tenis"];

    echo "<p>Valores del array: ";
    for ($i = 0; $i < count($deportes); $i++) {
        echo $deportes[$i] . ", ";
    }
    echo "</p>";

    echo "<p>Total de valores que contiene el array: " . count($deportes) . "</p>";

    echo "<p>Puntero situado en el primer elemento del array: " . current($deportes) . "</p>";

    echo "<p>Avanzamos el puntero una posición: " . next($deportes) . "</p>";

    echo "<p>Colocamos el puntero en la última posición del array: " . end($deportes) . "</p>";

    echo "<p>Retrocedemos una posicón el puntero: " . prev($deportes) . "</p>";
    ?>
</body>

</html>
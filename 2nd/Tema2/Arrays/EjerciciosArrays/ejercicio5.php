<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 5</title>
</head>

<body>
    <?php
    $arr = ["Nombre" => "Pedro Torres", "Dirección" => "C/Mayor, 37", "Teléfono" => 123456789];
    foreach ($arr as $clave => $valor) {
        echo "<p>" . $clave . ": " . $valor . "</p>";
    }
    ?>
</body>

</html>
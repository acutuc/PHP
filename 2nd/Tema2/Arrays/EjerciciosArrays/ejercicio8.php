<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 8</title>
</head>

<body>
    <?php
    $arr = ["Pedro", "Ismael", "Sonia", "Clara", "Susana", "Alfonso", "Teresa"];

    echo "<ul>";
    foreach ($arr as $clave => $valor) {
        echo "<li>".$valor."</li>";
    }
    echo "</ul>";
    ?>
</body>

</html>
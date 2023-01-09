<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 1</title>
</head>

<body>
    <?php
    require "class_fruta.php";

    $pera = new Fruta();

    //El arrow reemplaza al "." de Java.
    $pera->set_color("Verde");
    $pera->set_tamanio("Mediano");

    echo "<h1>Información de mi fruta pera</h1>";
    echo "<p><strong>Color: </strong>" . $pera->get_color() . "</p>";
    echo "<p><strong>Tamaño: </strong>" . $pera->get_tamanio() . "</p>";
    ?>
</body>

</html>
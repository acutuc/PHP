<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 3</title>
</head>

<body>
    <?php
    require "class_fruta.php";

    echo "<h1>Información de mis frutas</h1>";

    //Accedemos al método desde fuera de la propia clase:
    echo "<p>Frutas creadas hasta ahora: ".Fruta::cuantaFruta()."</p>";
    echo "<p>Creando una fruta...</p>";

    $pera = new Fruta("Verde", "Grande");

    echo "<p>Frutas creadas hasta ahora: ".Fruta::cuantaFruta()."</p>";

    echo "<p>Creando una fruta...</p>";
    $platano = new Fruta("Amarillo", "Pequeño");

    echo "<p>Frutas creadas hasta ahora: ".Fruta::cuantaFruta()."</p>";

    echo "<p>DESTRUYENDO una fruta...</p>";
    unset($platano);
    echo "<p>Frutas creadas hasta ahora: ".Fruta::cuantaFruta()."</p>";

    ?>
</body>

</html>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 7</title>
</head>
<body>
    <?php
    require "class_pelicula.php";

    $pelicula = new Pelicula("Ad Astra", "2019", "James Gray", true, "4", "2023-01-5");

    $pelicula->imprimir();

    $pelicula2 = new Pelicula("Origen", "2010", "Christopher Nolan", false, "3.5", null);

    $pelicula2->imprimir();

    ?>    
</body>
</html>
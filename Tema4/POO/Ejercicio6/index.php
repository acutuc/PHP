<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 6</title>
</head>
<body>
    <?php
    require "class_menu.php";

    $menu = new Menu();
    $menu->cargar("http://www.msn.com", "MSN");
    $menu->cargar("http://www.google.com", "Google");

    $menu->vertical();

    $menu->horizontal();
    ?>    
</body>
</html>
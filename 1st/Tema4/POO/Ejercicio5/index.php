<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 5</title>
</head>
<body>
    <?php
    require "class_empleado.php";
    
    $empleado1 = new Empleado("Juanito", "6000");
    $empleado2 = new Empleado("Jose Luis", "1500");

    echo "<h1>Información de los empleados:</h1>";

    $empleado1->imprimir();
    $empleado2->imprimir();
    ?>    
</body>
</html>

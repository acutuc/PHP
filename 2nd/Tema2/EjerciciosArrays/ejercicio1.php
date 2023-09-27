<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 1</title>
</head>

<body>
    <?php
    $arr = [];
    for ($i = 1; $i <= 10; $i++) {
        $arr[$i] = $i * 2;
        echo $arr[$i] . "<br/>";
    }

    ?>
</body>

</html>
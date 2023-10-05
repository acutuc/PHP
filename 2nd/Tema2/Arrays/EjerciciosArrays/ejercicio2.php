<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 2</title>
</head>
<body>
    <?php
        $v[1] = 90;
        $v[30] = 7;
        $v["e"] = 99;
        $v["hola"] = 43;

        foreach ($v as $clave => $valor) {
            echo "<p>Clave: ".$clave.". Valor: ".$valor."</p>";
        }
    ?>
</body>
</html>
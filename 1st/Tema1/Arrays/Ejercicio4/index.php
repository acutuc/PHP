<!DOCTYPE html>
<html>
    <head>
        <title>Ejercicio 4</title>
        <meta charset="UTF-8">
    </head>
    <body>
        <h1>Ejercicio 4</h1>
        <p>Crea un array e introduce los siguientes valores: Pedro, Ana, 34 y 1, respectivamente sin asignar el índice de la matriz. Muestra el esquema del array con print_r().</p>
        <?php
            $valores[] = "Pedro";
            $valores[] = "Ana";
            $valores[] = 34;
            $valores[] = 1;

            echo print_r($valores);
        ?>
    </body>
</html>
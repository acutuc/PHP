<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Ejercicio 10</title>
        <meta charset="UTF-8">
    </head>
    <body>
        <h1>Ejercicio 10</h1>
        <p>Rellena un array de 10 enteros, con los 10 primeros números naturales. Calcula la media de los que están en posiciones pares y muestra los impares por pantalla.</p>
        <?php
            $enteros = [];
            $media = 0;
            $contador = 0;
            echo "<p>Números impares: ";
            for($i = 0; $i < 10; $i++){
                //El 0 no es un número natural.
                $enteros[$i] = $i+1;
                //Calculamos la media de los números en POSICIONES (no números) pares.
                if($i % 2 == 0 && $i != 0){
                    $media += $enteros[$i];
                    $contador++;
                }
                if($enteros[$i] % 2 != 0){
                    echo $enteros[$i].", ";
                }
            }
            echo "</p>";
            $media = $media / $contador;

            echo "<p>La media de los números en posiciones pares es: ".$media."</p>";
        ?>
    </body>
</html>
<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Ejercicio 16</title>
        <meta charset="UTF-8">
    </head>
    <body>
        <h1>Ejercicio 16</h1>
        <p>
            Crea un array con los siguientes valores: 5 => 1, 12 => 2, 13 => 56, x => 42. Muestra el contenido. Cuenta el número de elementos que tiene y muéstralo por pantalla.
            A continuación borra el elemento de la posición 5. Vuelve a mostrar el contenido y por último elimina el array.
        </p>
        <?php
        	$arr = array(5 => 1, 12 => 2, 13 => 56, "x" => 42);
            echo "<p>Número de elementos: ".count($arr)."</p>";

            unset($arr[5]);
            print_r($arr);
        ?>
    </body>
</html>

<!DOCTYPE html>
<html>
    <head>
        <title>Ejercicio 6</title>
        <meta charset="UTF-8">
    </head>
    <body>
        <h1>Ejercicio 6</h1>
        <p>Crea un array introduciendo las ciudades: Madrid, Barcelona, Londres, New York, Los Ángeles, Chicago, sin asignar índices al array.
            A continuación, muestra el contenido del array haciendo un recorrido diciendo el valor correspondiente a cada índice, ejemplo:</p>
        <p><i>La ciudad con el índice 0 tiene el nombre Madrid.</i></p>
        <?php
            $ciudades[] = "Madrid";
            $ciudades[] = "Barcelona";
            $ciudades[] = "Londres";
            $ciudades[] = "New York";
            $ciudades[] = "Los Ángeles";
            $ciudades[] = "Chicago";

            for($i = 0; $i < count($ciudades); $i++){
                echo "La ciudad con el índice $i tiene el nombre $ciudades[$i]<br/>";
            }
        ?>
    </body>
</html>
<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Ejercicio 7</title>
        <meta charset="UTF-8">
    </head>
    <body>
        <h1>Ejercicio 7</h1>
        <p>Repite el ejercicio anterior pero ahora si se ha de crear índices, ejemplo:</p>
        <p><i>El índice del array que contiene como valor Madrid es MD</i></p>
        <?php
            $ciudades["MD"] = "Madrid";
            $ciudades["BCN"] = "Barcelona";
            $ciudades["LND"] = "Londres";
            $ciudades["NY"] = "New York";
            $ciudades["LA"] = "Los Ángeles";
            $ciudades["CHI"] = "Chicago";

            foreach($ciudades as $key => $value){
                echo "El índice del array que contiene como valor $value es $key<br/>";
            }
        ?>
    </body>
</html>
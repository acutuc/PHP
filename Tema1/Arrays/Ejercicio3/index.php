<!DOCTYPE html>
<html>
    <head>
        <title>Ejericio 3</title>
        <meta charset="UTF-8">
    </head>
    <body>
        <h1>Ejercicio 3</h1>
        <p>Realiza un programa que muestre las películas que se han visto. Crear un array que contenga los meses de enero, febrero, marzo y abril, asignando los valores 9, 12, 0 y 17, respectivamente.
            Si en alguno de los meses no se ha visto ninguna película, no ha de mostrar la información de ese mes.</p>
            <?php
            $pelisVistas = array("enero" => 9, "febrero" => 12, "marzo" => 0, "abril" => 17);

            foreach ($pelisVistas as $key => $value) {
                if($value > 0){
                    echo "<p>$key</p>";
                }
            }

            ?>
    </body>
</html>
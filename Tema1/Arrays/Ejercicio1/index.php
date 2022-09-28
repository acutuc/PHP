<!DOCTYPE html>
<html lang="es">
    <head>
        <titlte>Ejercicio 1</title>
        <meta charset="UTF-8">
    </head>
    <body>
        <h1>Ejercicio1</h1>
        <p>Almacena en un array los 10 primeros números pares. Imprímelos cada uno en una línea.</p>
        <?php
        	for($i = 0; i < 10; i++){
        		echo "<p>Par número ".$i+1.": ".$i+2"</p>"
        	}
        ?>
    </body>
</html>

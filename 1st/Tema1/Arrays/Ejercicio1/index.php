<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Ejercicio 1</title>
        <meta charset="UTF-8">
    </head>
    <body>
        <h1>Ejercicio1</h1>
        <p>Almacena en un array los 10 primeros números pares. Imprímelos cada uno en una línea.</p>
        <?php
        	for($i = 1; $i <= 10; $i++){
                $pares[$i] = $i*2;
        		echo "<p>Par número ".$i.": ".$pares[$i]."</p>";
        	}
        ?>
    </body>
</html>

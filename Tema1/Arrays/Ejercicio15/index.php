<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Ejercicio 15</title>
        <meta charset="UTF-8">
    </head>
    <body>
        <h1>Ejercicio 15</h1>
        <p>
            Implementa un array asociativo con los siguientes valores y ordénalo de menor a mayor. Muestra los valores en una tabla.
        </p>
        <p>
            $numeros = array(3, 2, 7, 123, 5, 1);
        </p>
        <?php
        	$numeros = array(0 => 3, 1 => 2, 2=> 7, 3=> 123, 4=> 5, 5=> 1);
            sort($numeros);

            echo "<table border = '1'>";
                echo "<tr>";
                    foreach($numeros as $indice => $valor){
                        echo "<td>".$indice."</td>";
                    }
                echo "</tr>";
                echo "<tr>";
                    foreach($numeros as $indice => $valor){
                        echo "<td>".$valor."</td>";
                    }
                echo "</tr>";
            echo "</table>";
        ?>
    </body>
</html>

<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Ejercicio 8</title>
        <meta charset="UTF-8">
    </head>
    <body>
        <h1>Ejercicio 8</h1>
        <p>Crea un array con los nombres Pedro, Ismael, Sonia, Clara, Susana, Alfonso y Teresa. Muestra el número de elementos que contiene y cada elemento en una lista no numerada.</p>
        <?php
            $nombres[] = "Pedro";
            $nombres[] = "Ismael";
            $nombres[] = "Sonia";
            $nombres[] = "Clara";
            $nombres[] = "Susana";
            $nombres[] = "Alfonso";
            $nombres[] = "Teresa";

            echo "El array contiene ".count($nombres)." elementos<br/>";
            for($i = 0; $i < count($nombres); $i++){
                
                echo "<ul>
                        <li>$nombres[$i]</li>
                    </ul>";
            }             
            
            ?>
    </body>
</html>
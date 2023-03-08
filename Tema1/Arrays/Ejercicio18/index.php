<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Ejercicio 18</title>
        <meta charset="UTF-8">
    </head>
    <body>
        <h1>Ejercicio 18</h1>
        <p>
            Crea un array llamado deportes e introduce los siguientes valores: fútbol, baloncesto, natación y tenis. Haz el recorrido de la matriz con un for para mostrar sus valores.
            A continuación realiza las siguientes operaciones.
        </p>
        <ul>
            <li>Muestra el total de valores que contiene.</li>
            <li>Sitúa el puntero en el primer elemento del array y muestra el valor actual, es decir, donde está situado el puntero actualmente.</li>
            <li>Avanza una posición y muestra el valor actual.</li>
            <li>Coloca el puntero en la última posición y muestra su valor.</li>
            <li>Retrocede una posición y muestra este valor.</li>
        </ul>
        <?php
        	$deportes = ["fútbol", "baloncesto", "natación", "tenis"];

            echo "<p>Valores del array: ";
            for($i = 0; $i < count($deportes); $i++){
                echo $deportes[$i].", ";
            }
            echo "</p>";

            echo "<p>Total de valores que contiene el array: ".count($deportes)."</p>";

            echo "<p>Puntero situado en el primer elemento del array: ".current($deportes)."</p>";

            echo "<p>Avanzamos el puntero una posición: ".next($deportes)."</p>";

            echo "<p>Colocamos el puntero en la última posición del array: ".end($deportes)."</p>";

            echo "<p>Retrocedemos una posicón el puntero: ".prev($deportes)."</p>";
        ?>
    </body>
</html>

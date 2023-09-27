<!DOCTYPE html>
<html>
    <head>
        <title>Ejercicio 5</title>
        <meta charset="UTF-8">
    </head>
    <body>
        <h1>Ejercicio 5</h1>
        <p>Crea un array asociativa para introducir los datos de una persona:</p>
        <p>Nombre: Pedro Torres
            Dirección: C/ Mayor, 37
            Teléfono: 123456789</p>
        <p>Al acabar muestra los datos por pantalla.</p>
        <?php
            $datos = array("Nombre" => "Pedro Torres", "Dirección" => "C/ Mayor, 37", "Teléfono" => "123456789");

            foreach($datos as $key => $value){
                echo "$key --> $value<br/>";
            }
        ?>
    </body>
</html>
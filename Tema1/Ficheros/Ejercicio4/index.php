<?php
    if(isset($_POST["btnEnviar"])){
        $error_caja1 = solo_numeros();
        $error_caja2 = solo_numeros();
        $error_formulario = $error_caja1 || $error_caja2;
    }
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Ejercicio 4</title>
        <meta charset="UTF-8">
    </head>
    <body>
        <h1>Ejercicio 4</h1>
        <p>
            Realizar un formulario que conste de dos cajas de texto para introducir dos valores y un botón de envío. Al presionar sobre el botón de envío se debe mostrar por pantalla el contenido de los dos valores,
            la suma, resta, producto, cociente y el módulo.<br/>
            Utilizar el método POST. Se ha de crear el código en un único documento PHP.
        </p>
        <form action="index.php" method="POST" enctype="multipart/form-data">
            <p>
                <label for="caja1">Introduzca un número: </label><input type="text" id="caja1" name="caja1">
            </p>
            <p>
                <label for="caja2">Introduzca un número: </label><input type="text" id="caja2" name="caja2">
            </p>
            <button type="submit" name="btnEnviar">Enviar</button>
        </form> 
        <?php

        ?>
    </body>
</html>
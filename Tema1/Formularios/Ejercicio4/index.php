<?php
    if(isset($_POST["btnEnviar"])){
        $error_caja1 = "" || !is_numeric($_POST["caja1"]);
        $error_caja2 = "" || !is_numeric($_POST["caja2"]);
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
                <label for="caja1">Introduzca un número: </label><input type="text" id="caja1" name="caja1" value="<?php if(isset($_POST['caja1'])) echo $_POST['caja1']?>">
                <?php
                    if(isset($_POST["btnEnviar"]) && $error_caja1){
                        echo "<span class='error'>Debe introducir un número</span>";
                    }
                ?>
            </p>
            <p>
                <label for="caja2">Introduzca un número: </label><input type="text" id="caja2" name="caja2" value="<?php if(isset($_POST['caja2'])) echo $_POST['caja2']?>">
                <?php
                    if(isset($_POST["btnEnviar"]) && $error_caja2){
                        echo "<span class='error'>Debe introducir un número</span>";
                    }
                ?>
            </p>
            <button type="submit" name="btnEnviar">Enviar</button>
            <?php
                if(isset($_POST["btnEnviar"]) && is_numeric($_POST["caja1"]) && is_numeric($_POST["caja2"]) && !$error_formulario){
                    echo "<p><strong>Contenido de la primera caja: </strong>".$_POST["caja1"]."</p>";
                    echo "<p><strong>Contenido de la segunda caja: </strong>".$_POST["caja2"]."</p>";
                    echo "<p><strong>Suma: </strong>".$_POST["caja1"] + $_POST["caja2"]."</p>";
                    echo "<p><strong>Resta: </strong>".$_POST["caja1"] - $_POST["caja2"]."</p>";
                    echo "<p><strong>Producto: </strong>".$_POST["caja1"] * $_POST["caja2"]."</p>";
                    echo "<p><strong>Cociente: </strong>".$_POST["caja1"] / $_POST["caja2"]."</p>";
                    echo "<p><strong>Módulo: </strong>".$_POST["caja1"] % $_POST["caja2"]."</p>";
                }
            ?>
        </form> 
        <?php

        ?>
    </body>
</html>
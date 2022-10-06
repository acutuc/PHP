<?php
    if(isset($_POST["btnCalcular"])){
        $error_fecha1 = $_POST["fecha1"] == "";
        $error_fecha2 = $_POST["fecha2"] == "";
        $error_formulario = $error_fecha1 || $error_fecha2;
    }
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Ejercicio 3</title>
        <meta charset="UTF-8">
        <style>
            #div1 {background-color: lightblue;
                    border: 2px solid black;};
        </style>
    </head>
    <body>
        <div id="div1">
            <h2 align="center">Fechas - Formulario</h2>
            <form method="post" action="index.php" ectype="multipart/form-data">
                <label for="fecha1">Introduzca una fecha: </label>
                <input type="date" id="fecha1" name="fecha1" value="<?php  if(isset($_POST["fecha1"])) echo $_POST["fecha1"]?>">
                <?php
                    if(isset($_POST["btnCalcular"]) && $error_fecha1){
                        echo "<span class='error'>***Seleccione una fecha***</span>";
                    }
                ?><br/>
                <label for="fecha2">Introduzca una fecha: </label>
                <input type="date" id="fecha2" name="fecha2" value="<?php  if(isset($_POST["fecha2"])) echo $_POST["fecha2"]?>">
                <?php
                    if(isset($_POST["btnCalcular"]) && $error_fecha1){
                        echo "<span class='error'>***Seleccione una fecha***</span>";
                    }
                ?>
                <p>
                    <button type="submit" name="btnCalcular">Calcular</button>
                </p>
            </form>
            <?php
                if(isset($_POST["btnCalcular"]) && !$error_formulario){
                    echo "<h2 align='center'>Fechas - Respuesta</h2>";
                    $seg1 = strtotime($_POST["fecha1"]);
                    $seg2 = strtotime($_POST["fecha2"]);

                    $dias = ($seg1 - $seg2) / (60*60*24);
                    $dias = floor(abs($dias));

                    echo "<p>La difrencia en días entra las dos fechas introducidas es de ".$dias."</p>";
                }
            ?>
        </div>
    </body>
</html>
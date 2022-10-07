<?php
    if(isset($_POST["btnCalcular"])){
        $error_fecha1 = !checkdate($_POST["mes1"], $_POST["dia1"], $_POST["anio1"]);
        $error_fecha2 = !checkdate($_POST["mes2"], $_POST["dia2"], $_POST["anio2"]);
        $error_formulario = $error_fecha1 || $error_fecha2;
    }
?>
<!DOCTYPE html>
<?php
    $meses = array(1=>"Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");


?>
<html>

<head>
    <title>Ejercicio 2</title>
    <meta charset="UTF-8">
    <style>
    #div1 {
        background-color: lightblue;
        border: 2px solid black;
    };
    </style>
</head>

<body>
    <div id="div1">
        <h2 align="center">Fechas - Formulario</h2>
        <form method="post" action="index.php" enctype="multipart/form-data">
            <p>Introduzca una fecha:</p>
            <p>
                <label for="dia1">Día: </label>
                <select id="dia1" name="dia1">
                    <?php
                            for($i = 1; $i < 32; $i++){
                                //echo "option value=".$i.">".sprintf("%02",$i)."</option>";
                                if(isset($_POST["btnCalcular"]) && $_POST["dia1"] == $i){
                                    if($i < 10){
                                        echo "<option value=".$i." selected>"."0".$i."</option>";
                                    }else{
                                        echo "<option value=".$i." selected>".$i."</option>";
                                    }
                                } 
                                if($i < 10){
                                    echo "<option value=".$i.">"."0".$i."</option>";
                                }else{
                                    echo "<option value=".$i.">".$i."</option>";
                                }
                                
                            }
                        ?>
                </select>
                <label for="mes1">Mes: </label>
                <select id="mes1" name="mes1">
                    <?php
                            foreach($meses as $indice => $valor){
                                if(isset($_POST["btnCalcular"]) && $_POST["mes1"] == $indice){
                                    echo "<option value=".$indice." selected>".$valor."</option>";
                                }
                                echo "<option value=".$indice.">".$valor."</option>";
                            }
                        ?>
                </select>
                <label for="anio1">Año: </label>
                <select id="anio1" name="anio1">
                    <?php
                            $anio_actual = date("Y");
                            for($i = $anio_actual - 50; $i <= $anio_actual; $i++){
                                if(isset($_POST["btnCalcular"]) && $_POST["anio1"] == $i){
                                    echo "<option value=".$i." selected>".$i."</option>";
                                }
                                echo "<option value=".$i.">".$i."</option>";
                            }
                        ?>
                </select>
                <?php
                        if(isset($_POST["btnCalcular"]) && $error_fecha1){
                            echo "<span class='error'>***Fecha no válida***</span>";
                        }
                    ?>
            </p>
            <p>Introduzca otra fecha:</p>
            <p>
                <label for="dia2">Día: </label>
                <select id="dia2" name="dia2">
                    <?php
                            for($i = 1; $i < 32; $i++){
                                //echo "option value=".$i.">".sprintf("%02",$i)."</option>";
                                if(isset($_POST["btnCalcular"]) && $_POST["dia2"] == $i){
                                    if($i < 10){
                                        echo "<option value=".$i." selected>"."0".$i."</option>";
                                    }else{
                                        echo "<option value=".$i." selected>".$i."</option>";
                                    }
                                } 
                                if($i < 10){
                                    echo "<option value=".$i.">"."0".$i."</option>";
                                }else{
                                    echo "<option>".$i."</option>";
                                }
                                
                            }
                        ?>
                </select>
                <label for="mes2">Mes: </label>
                <select id="mes2" name="mes2">
                    <?php
                            foreach($meses as $indice => $valor){
                                if(isset($_POST["btnCalcular"]) && $_POST["mes2"] == $indice){
                                    echo "<option value=".$indice." selected>".$valor."</option>";
                                }
                                echo "<option value=".$indice.">".$valor."</option>";
                            }
                        ?>
                </select>
                <label for="anio2">Año: </label>
                <select id="anio2" name="anio2">
                    <?php
                            $anio_actual = date("Y");
                            for($i = $anio_actual - 50; $i <= $anio_actual; $i++){
                                if(isset($_POST["btnCalcular"]) && $_POST["anio2"] == $i){
                                    echo "<option value=".$i." selected>".$i."</option>";
                                }
                                echo "<option value=".$i.">".$i."</option>";
                            }
                        ?>
                </select>
                <?php
                        if(isset($_POST["btnCalcular"]) && $error_fecha2){
                            echo "<span class='error'>***Fecha no válida***</span>";
                        }
                    ?>
            </p>
            <p>
                <button type="submit" name="btnCalcular">Calcular</button>
            </p>
        </form>
    </div>
    <?php
                if(isset($_POST["btnCalcular"]) && !$error_formulario){
                    echo "<h2 align='center'>Fechas - Respuesta</h2>";
                    $seg1 = mktime(0, 0, 0, $_POST["mes1"], $_POST["dia1"], $_POST["anio1"]);
                    $seg2 = mktime(0, 0, 0, $_POST["mes2"], $_POST["dia2"], $_POST["anio2"]);

                    $dias = ($seg1 - $seg2) / (60*60*24);
                    $dias = floor(abs($dias));

                    echo "<p>La difrencia en días entra las dos fechas introducidas es de ".$dias."</p>";
                }
            ?>
</body>

</html>
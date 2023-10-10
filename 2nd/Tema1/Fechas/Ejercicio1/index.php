<?php

	function fecha_no_buena($fecha){
		$error_fecha = strlen($fecha) != 10;
		if(!$error_fecha){
			$dia = substr($fecha, 0, 2);
			$separador1 = substr($fecha, 2, 1);
			$mes = substr($fecha, 3, 2);
			$separador2 = substr($fecha, 5, 1);
			$anio = substr($fecha, 6, 4);
			
			$error_separadores = $separador1 != "/" || $separador2 != "/";
			
			$error_numeros = !is_numeric($dia) || !is_numeric($mes) || !is_numeric($anio); 
			
			$error_fecha = $error_separadores || $error_numeros || !checkdate($mes, $dia, $anio);
		}
		return $error_fecha;
	}

	if(isset($_POST["btnComparar"])){
		$error_fecha1 = $_POST["fecha1"] == "" || fecha_no_buena(trim($_POST["fecha1"]));
		$error_fecha2 = $_POST["fecha2"] == "" || fecha_no_buena(trim($_POST["fecha2"]));
		$error_form = $error_fecha1 || $error_fecha2;
	}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Ejercicio 1</title>
        <meta charset="UTF-8">
    </head>
    <body>
        <h1>Ejercicio 1</h1>
        <style>
        #div1{background-color: lightblue;
        	border: 2px solid black;};
        #div2{background-color: lightgreen;
        	border: 2px solid black};
        </style>
        <div id="div1">
            <h2 align="center">Fechas - Formulario</h2>
            <form method="POST" action="index.php" ectype="multipart/form-data">
                <label for="fecha1">Introduzca una fecha: (DD/MM/YYYY)</label>
                <input type="text" name="fecha1" id="fecha1" value="<?php if(isset($_POST["fecha1"])) echo $_POST["fecha1"]?>"/>
                <?php
					if(isset($_POST["btnComparar"]) && $error_fecha1){
                		if($_POST["fecha1"] == ""){
                			echo "<span class = 'error'>***Campo vacío***</span>";
                		}else{
                			echo "<span class = 'error'>***La fecha indtroducida no es válida</span>";
                		}
                	}
                ?><br/>
                <label for="fecha2">Introduzca una fecha: (DD/MM/YYYY)</label>
                <input type="text" name="fecha2" id="fecha2" value="<?php if(isset($_POST["fecha2"])) echo $_POST["fecha2"]?>"/>
                <?php
					if(isset($_POST["btnComparar"]) && $error_fecha1){
                		if($_POST["fecha2"] == ""){
                			echo "<span class = 'error'>***Campo vacío***</span>";
                		}else{
                			echo "<span class = 'error'>***La fecha indtroducida no es válida</span>";
                		}
                	}
                ?><br/>
                <p>
                	<button type="submit" id="comparar" name="btnComparar">Comparar</button>
                </p>
            </form>
           </div>
           <div id="div2">
           <?php
           	if(isset($_POST["btnComparar"]) && !$error_form){
				echo "<h2 align = 'center'>Fechas - Respuesta</h2>";
            	
            	$fecha1 = explode("/", trim($_POST["fecha1"]));
            	$fecha2 = explode("/", trim($_POST["fecha2"]));
            		
            	$segundos1 = mktime(0, 0, 0, $fecha1[1], $fecha1[0], $fecha1[2]);
            	$segundos2 = mktime(0, 0, 0, $fecha2[1], $fecha2[0], $fecha2[2]);
            		
				$dias = ($segundos1 - $segundos2) / (60*60*24);
				$dias = floor(abs($dias));
					
				echo "<p>La difrencia en días entra las dos fechas introducidas es de ".$dias."</p>";
            }
		?>
		</div>
    </body>
</html>

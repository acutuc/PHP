<!DOCTYPE html>
<html lang="es">
	<head>
		<title>Prueba 1</title>
		<meta charset="UTF-8"/>
	</head>
	<body>
		<?php
			
			echo "<h1>Esta es mi primera web DWESE</h1>";
			
			/*Con $ almacenamos varialbes*/
			$a=8;
			$b=7;
			echo "<p>El resultado de sumar 8 y 7 es: ".($a+$b)."</p>";
				/*Con los "." al final y principio de cada sentencia, se concatenan.*/
			echo "<p>El resultado de restar 8 y 7 es: ".($a-$b)."</p>";
		?>
		<h2>Y ahora más código</h2>
		<?php
			echo "<p>El resultado de multiplicar 8 y 7 es: ".($a*$b)."</p>";
			
			/*Para concatenar variables numéricas:*/
			echo "<p>Concatenamos dos variables numéricas: ".$a.$b."</p>";
		?>
	</body>
</html>

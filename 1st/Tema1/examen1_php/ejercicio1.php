<?php
function crear_fichero_polybio($fichero)
{
	$linea = "i/j";

	for($i = 0; $i < 5; $i++){
		$linea .=";".$i;
	}
	fputs($fichero, $linea.PHP_EOL);

	$k = ord("A");

	for($i = 1; $i <= 5; $i++){
		$linea = $i;

		for($j= 0; $j < 5; $j++){
			if(chr($k) == "J"){
				$k++;
			}
			$linea .= ";".chr($k);
			$k++;
		}


		fputs($fichero, $linea.PHP_EOL);
	}
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
	<form method="post" action="ejercicio1.php">
		<button type="submit" name="btnGenerar">Generar</button>
	</form>
	<?php
	if (isset($_POST["btnGenerar"])) {
		$fichero = fopen("claves_polybios.txt", "w");

		if (!$fichero) {
			die("No se ha podido crear el fichero");
		}

		echo "<h2>Respuesta</h2>";

		crear_fichero_polybio($fichero);

		echo "<textarea>" . file_get_contents("claves_polybios.txt") . "</textarea>";

		echo "<p>Fichero generado con éxito</p>";

		fclose($fichero);
	}
	?>
</body>

</html>
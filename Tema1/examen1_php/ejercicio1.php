<?php
if (isset($_POST["btnGenerar"])) {
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

		fputs($fichero, "i/j;1;2;3;4;5" . PHP_EOL);

		for ($i = 1; $i < 6; $i++) {
			$linea = $i;
			for ($j = 65; $j < 91; $j++) {

				if (strlen($linea) < 11 && $j != ord("J") && $j != ord("Ñ")) {
					$linea .= ";" . chr($j);
				}

			}

			fputs($fichero, $linea . PHP_EOL);
			$linea = "";
		}
		//A == 65
		//Z == 90
		echo "<textarea>";

		echo "</textarea>";

		fclose($fichero);
	}
	?>
</body>

</html>
<?php
function ejercicio($separador, $texto)
{
	$aux = [];
	$palabra = "";
	for($i = 0; $i < strlen($texto); $i++){

		if($texto[$i] == $separador && $palabra != ""){
			$aux[] = $palabra;
			$palabra="";
		}
		if($texto[$i] != $separador){
			$palabra .= $texto[$i];
		}

		if($i == strlen($texto) - 1){
			$aux[] = $palabra;
		}
	}

	return $aux;
}


if (isset($_POST["btnContar"])) {
	$error_formulario = $_POST["texto"] == "";
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
	<title>Ejercicio 2. Longitud de las palabrasa extraídas</title>
	<meta charset="UTF-8">
</head>

<body>
	<h1>Ejercicio 2. Longitud de las palabras extraídas</h1>
	<p>
	<form method="post" action="ejercicio2.php">
		<label for="texto">Introduzca un Texto: </label><input type="text" name="texto" id="texto">
		<?php
		if (isset($_POST["texto"]) && $error_formulario) {
			echo "<span class='error'>*Campo vacío*</span>";
		}
		?>
		</p>
		<p>
			<label for="separador">Elija un separador: </label>
			<select id="separador" name="separador">
				<option value="," <?php if (isset($_POST["separador"]) && $_POST["separador"] == ",") echo "selected" ?>>, (coma)</option>
				<option value=";" <?php if (isset($_POST["separador"]) && $_POST["separador"] == ";") echo "selected" ?>>; (punto y coma)</option>
				<option value=" " <?php if (isset($_POST["separador"]) && $_POST["separador"] == " ") echo "selected" ?>> (espacio)</option>
				<option value=":" <?php if (isset($_POST["separador"]) && $_POST["separador"] == ":") echo "selected" ?>>: (dos puntos)</option>
			</select>
		</p>
		<p>
			<button type="submit" name="btnContar">Contar</button>
		</p>
	</form>
	<?php
	if (isset($_POST["btnContar"]) && !$error_formulario) {
		echo "<h2>Respuesta</h2>";
		for($i = 0; $i < count(ejercicio($_POST["separador"], $_POST["texto"])); $i++){
			echo "<p>".$i+1 .". ".ejercicio($_POST["separador"], $_POST["texto"])[$i]." ( ".strlen(ejercicio($_POST["separador"], $_POST["texto"])[$i])." ) </p>";
		}
	}
	?>
</body>

</html>
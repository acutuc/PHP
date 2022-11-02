<?php
	if(isset($_POST["btnSubir"])){
		$error_fichero = $_FILES["fichero"]["name"] == "" || $_FILES["fichero"]["size"] > 1000000 || $_FILES["fichero"]["error"] || $_FILES["fichero"]["type"] != "text/plain";
	}
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<title>Ejercicio 4-2</title>
		<meta charset="UTF-8">
	</head>
	<body>
		<h1>Ejercicio 4-2</h1>
		<h3>Horario de los grupos</h3>
		<?php
			@$fichero = fopen("Horario/horarios.txt", "r");
			if(!$fichero){
			?>
			<h2>No se encuentra el archivo <em>Horario/horarios.txt</em></h2>
			<form action="ejercicio4-2.php" method="post" enctype="multipart/form-data">
				<label for="archivo">Seleccione una archivo txt no superior a 1MB: </label><input type="file" accept=".txt" id="archivo" name="fichero">
				
				
			</form>
		<?php
			if(isset($_POST["btnSubir"]) && !$error_fichero){
				if($_FILES["fichero"]["name"] != "horarios.txt"){
					echo "<span class='error'>*No es horarios.txt*</span>";
				}
				if($_FILES["fichero"]["size"] > 1000000){
					echo "<span class='error'>*El archivo supera 1MB de tamaño*</span>";
				}
				if($_FILES["fichero"]["type"] != "text/plain"){
					echo "<span class='error'>*No es formato .txt*</span>";
				}
			}
		?>
		<p>
			<button type="submit" name="btnSubir">Subir</button>
		</p>
		<?php
		}else{
			
		}
		?>
	</body>
</html>

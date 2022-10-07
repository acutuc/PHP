<?php
if(isset($_POST["primera"])){
$error = (($_POST["primera"]==""));
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>Decimales</title>
<meta charset="UTF-8"/>
<style>
div {
border: 2px solid black;
padding-left: 10px;
padding-bottom: 10px;
}
h2 {
text-align: center;
}
#form {
background-color: #A9D5E5;
}
#resultados {
margin-top: 2em;
background-color: #88E08F;
}
</style>
</head>
<body>
<form method="post" action="index.php">
<div id="form">
<h2>Unifica separador decimal - Formulario</h2>
<p>Escribe varios números separados por espacios y uniiificaré el separador decimal a puntos</p>
<p><label for="primera">Números: </label>
<input type="text" name="primera" id="primera" value="<?php if(isset($_POST['primera'])){echo $_POST['primera'];} ?>"></input>
<?php
if(isset($_POST["primera"]) && $_POST["primera"]==""){
echo "<span class='error'>* Campo Vacio *</span>";
}
?></p>
<button type="submit" name="comprobar">Convertir</button>
</div>

<?php
if(isset($_POST["comprobar"]) && !$error) {
?>
<div id="resultados">
<h2>Unifica separador decimal - Resultado</h2>


<?php

$primera = trim($_POST["primera"]);

$resultado = str_replace(",",".", $primera);



echo "<p>Números originales </br>".$primera."</br> Números corregidos </br>".$resultado."</p>";
}
?>

</div>

</form>
</body>
</html>

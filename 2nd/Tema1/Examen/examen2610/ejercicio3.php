<?php
    function compruebaDesplazamiento(){
        
    }

    if(isset($_POST["btnCodificar"])){
        $error_texto = $_POST["texto"] == "";
        $error_desplazamiento = $_POST["desplazamiento"] == "";

        $error_fichero = $_FILES["archivo"]["name"] == "" || $_FILES["archivo"]["error"] || $_FILES["archivo"]["type"] != "text/plain" || $_FILES["archivo"]["size"] > 1024 * 1250;

        $error_form = $error_texto || $error_desplazamiento || $error_fichero;
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 3 PHP</title>
</head>
<body>
    <h1>Ejercicio 3. Codifica una frase</h1>
    <form method="post" action="ejercicio3.php" enctype="multipart/form-data">
        <p>
            <label for="texto">Introduzca un texto: </label>
            <input type="text" name="texto" id="texto" value="<?php if(isset($_POST["texto"])) echo $_POST["texto"] ?>">
        </p>
        <p>
            <label for="desplazamiento">Desplazamiento: </label>
            <input type="text" name="desplazamiento" id="desplazamiento" value="<?php if(isset($_POST["desplazamiento"])) echo $_POST["desplazamiento"] ?>">
        </p>
        <p>
            <label for="archivo">Seleccione el archivo de claves (.txt y menor de 1'25MB) </label>
            <input type="file" name="archivo" id="archivo" accept="text/plain">
        </p>
        <p>
            <button name="btnCodificar">Codificar</button>
        </p>
    </form>
    <?php
        if(isset($_POST["btnCodificar"]) && !$error_form){
            echo "si";
        }
    ?>
</body>
</html>
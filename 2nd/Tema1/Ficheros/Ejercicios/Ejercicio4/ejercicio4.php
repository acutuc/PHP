<?php
if (isset($_POST["btnEnviar"])) {
    $error_fichero = $_FILES["archivo"]["name"] == "" || $_FILES["archivo"]["error"] || $_FILES["archivo"]["type"] !== "text/plain" || $_FILES["archivo"]["size"] > 2500 * 1024;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .error {
            color: red;
        }

        .success {
            color: blue;
        }
    </style>
    <title>Ejercicio 4</title>
</head>

<body>
    <h1>Ejercicio 4</h1>
    <p>
        Realizar una web con un formulario que seleccione un fichero de texto y muestre por pantalla el número de palabras que contiene. Como ejemplo usar el
        archivo adjunto (pag2000.txt). Controlar que el fichero seleccionado por el
        usuario sea de tipo texto ( .txt) y que el tamaño máximo del archivo sea 2’5MB.
    </p>

    <form method="post" action="ejercicio4.php" enctype="multipart/form-data">
        <p>
            <label for="archivo">Seleccione un fichero txt:</label>
        </p>
        <p>
            <input type="file" name="archivo" id="archivo" accept=".txt">
            <?php
            if(isset($_POST["btnEnviar"]) && $error_fichero){
                if($_FILES["archivo"]["name"] == ""){
                    if($_FILES["archivo"]["error"]){
                        echo "<span class='error'>**ERROR**</span>";
                    }else{
                        echo "<span class='error'>**Fichero de más de 2.5MB**</span>";
                    }
                }
            }
            ?>
        </p>
        <p>
            <button type="submit" name="btnEnviar">Leer fichero</button>
        </p>
    </form>
    <?php
    if (isset($_POST["btnEnviar"]) && !$error_fichero) {
        $nombre_fichero = $_FILES["archivo"]["name"];

        @$fd = fopen($nombre_fichero, "r+");

        $cantidad_palabras = str_word_count(file_get_contents($nombre_fichero));

        echo "<p><span class='success'><strong>Cantidad de palabras del fichero: </strong>".$cantidad_palabras."</span>";
    }
    ?>
</body>

</html>
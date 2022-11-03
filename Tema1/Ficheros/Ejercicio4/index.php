<?php
if (isset($_POST["btnContar"])) {
    $error_formulario = $_FILES["archivo"]["name"] == "" || $_FILES["archivo"]["error"] || $_FILES["archivo"]["type"] != "text/plain" || $_FILES["archivo"]["size"] > 25 * 100000;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Ejercicio 4</title>
    <meta charset="UTF-8">
</head>

<body>
    <h1>Ejercicio 4</h1>
    <p>
        Realizar una web con un formulario que seleccione un fichero de texto y muestre por pantalla el número de palabras que contiene. Como ejemplo usar el
        archivo adjunto (pag2000.txt). Controlar que el fichero seleccionado por el
        usuario sea de tipo texto ( .txt) y que el tamaño máximo del archivo sea 2’5MB.
    </p>
    <form action="index.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="archivo">Seleccione un fichero de texto</label>
            <input type="file" name="archivo" id="archivo" accept=".txt">

            <?php
            if (isset($_POST["btnContar"]) && $error_formulario) {
                if ($_FILES["archivo"]["name"] != "") {
                    if ($_FILES["archivo"]["error"]) {
                        echo "<span class='error'>Error subiendo archivo al servidor</span>";
                    } elseif ($_FILES["archivo"]["type"] != "text/plain") {
                        echo "<span class='error'>Error. No has seleccionado un archivo .txt</span>";
                    } else {
                        echo "<span class='error'>Error. El tamaño del archivo supera los 2.5MB</span>";
                    }
                }
            }
            ?>
        </p>
        <p>
            <button type="submit" name="btnContar">Contar</button>
        </p>
    </form>
    <?php
    if (isset($_POST["btnContar"]) && !$error_formulario) {
        $n_palabras = str_word_count(file_get_contents($_FILES["archivo"]["tmp_name"]));
        echo "<h2><Respuesta: " . $n_palabras . " palabras</h2>";
    } else {
        echo "asdjoaisjd";
    }
    ?>
</body>

</html>
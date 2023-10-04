<?php
if (isset($_POST["btnEnviar"])) {
    $error_archivo = $_FILES["archivo"]["name"] == "" || $_FILES["archivo"]["error"] || !getimagesize($_FILES["archivo"]["tmp_name"]) || $_FILES["archivo"]["size"] > 500 * 1024;
}

if (isset($_POST["btnEnviar"]) && !$error_archivo) {
    echo "contesto con la info";
} else {
?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Teoría subir imagenes al servidor</title>
    </head>

    <body>
        <h1>Teoría subir imagenes al servidor</h1>
        <form method="post" action="index.php" enctype="multipart/form-data">
            <p>
                <label for="archivo">Seleccione un archivo imagen (Máx. 500KB): </label><input type="file" name="archivo" id="archivo" accept="image/*">
            </p>
            <?php
            if (isset($_POST["btnEnviar"]) && $error_archivo) {
                if ($_FILES["archivo"]["name"] != "") {
                    if ($_FILES["archivo"]["error"]) {
                        echo "<span class='error'>No se ha podido subir el archivo al servidor.</span>";
                    } elseif (!getimagesize($_FILES["archivo"]["tmp_name"])) {
                        echo "<span class='error'>El archivo seleccionado no es una imagen.</span>";
                    } else {
                        echo "<span class='error'>El archivo seleccionado supera los 500KB</span>";
                    }
                }
            }
            ?>
            <p>
                <button type="submit" name="btnEnviar">Enviar</button>
            </p>
        </form>
    </body>

    </html>
<?php
}
?>
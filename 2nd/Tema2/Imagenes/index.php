<?php
if (isset($_POST["btnEnviar"])) {
    $error_archivo = $_FILES["archivo"]["name"] == "" || $_FILES["archivo"]["error"] || !getimagesize($_FILES["archivo"]["tmp_name"]) || $_FILES["archivo"]["size"] > 500 * 1024;
}

if (isset($_POST["btnEnviar"]) && !$error_archivo) {
?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Datos del archivo subido</title>
        <style>
            .tam_imag {
                width: 40%;
            }
        </style>
    </head>

    <body>
        <h1>Datos del archivo subido</h1>
        <?php
        //CAMBIAR DE NOMBRE EL ARCHIVO:
        $nombre_nuevo = md5(uniqid(uniqid(), true));
        $array_nombre = explode(".", $_FILES["archivo"]["name"]);
        $extension = "";
        if (count($array_nombre) > 1) {
            $extension = "." . end($array_nombre);
        }
        $nombre_nuevo .= $extension;

        //MOVER EL ARCHIVO: 
        @$var = move_uploaded_file($_FILES["archivo"]["tmp_name"], "images/" . $nombre_nuevo);
        if ($var) {
            echo "<p><strong style='color:#32CD32;'>Archivo cargado correctamente.</strong></p>";
            echo "<h3>Datos de la imagen cargada</h3>";
            echo "<p><strong>\$_FILES[\"archivo\"][\"name\"]: </strong>" . $_FILES["archivo"]["name"] . "</p>";
            echo "<p><strong>\$_FILES[\"archivo\"][\"error\"]: </strong>" . $_FILES["archivo"]["error"] . "</p>";
            echo "<p><strong>\$_FILES[\"archivo\"][\"tmp_name\"]: </strong>" . $_FILES["archivo"]["tmp_name"] . "</p>";
            echo "<p><strong>\$_FILES[\"archivo\"][\"size\"]: </strong>" . $_FILES["archivo"]["size"] . " B</p>";
            echo "<p><strong>\$_FILES[\"archivo\"][\"type\"]: </strong>" . $_FILES["archivo"]["type"] . "</p>";
            echo "<p><img class='tam_imag' src='images/" . $nombre_nuevo . "' alt='Foto' title='Foto'/></p>";
        } else {
            echo "<p>No se ha podido mover la imagen a la carpeta destino en el servidor.</p>";
        }


        ?>
    </body>

    </html>
<?php
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
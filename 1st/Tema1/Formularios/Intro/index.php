<?php
if (isset($_POST["btnSubir"])) {
    //$_POST["foto"] NO EXISTIRÁ, ESTO ES A MODO EJEMPLO.
    //Se generará una variable multidimensional: $_FILES["foto"]["X"].
    //$_FILES["foto"]["name"], en "name" irá el nombre del archivo.
    //$_FILES["foto"]["error"], si hay un error aparecerá en "error".
    //$_FILES["foto"]["tmp_name"], en "tmp_name" se guardará la dirección del servidor, de forma temporal.
    //$_FILES["foto"]["size"], nos indica el tamaño en bytes.
    //$_FILES["foto"]["type"], nos indica el tipo de archivo que es.

    $error_archivo = $_FILES["foto"]["name"] == "" || $_FILES["foto"]["error"] || !getimagesize($_FILES["foto"]["tmp_name"]) || $_FILES["foto"]["size"] > 500 * 1024;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Teoría ficheros</title>
    <meta charset="UTF-8">
</head>

<body>
    <h1>Subir archivos</h1>
    <form action="index.php" method="post" enctype="multipart/form-data">
        <p>
            <!--El $_POST["foto"] no existe-->
            <label for="foto">Seleccione un archivo imagen inferior a 500KB. </label>
            <input type="file" name="foto" id="foto" accept="image/*" />
            <!--Aquí no hace falta el span de error, el propio type="file" dice que no hay archivo cargado.-->
            <?php
            //Si hay submit y error:
            if (isset($_POST["btnSubir"]) && $error_archivo) {
                //Si el nombre del archivo es distinto a vacío.
                if ($_FILES["foto"]["name"] != "") {
                    //Si hay error en la foto:
                    if ($_FILES["foto"]["error"]) {
                        echo "<span class='error'>Error en la subida del archivo.</span>";
                        //Si al haber un tamaño de 0KB, no es una imagen.
                    } elseif (!getimagesize($_FILES["foto"]["tmp_name"])) {
                        echo "<span class='error'>Error. No has seleeccionado un archivo imagen.</span>";
                        //Nos queda la última condición, el tamaño de la imagen es mayor.
                    } else {
                        echo "<span class='error'>Error. El tamaño de la imagen seleccionada es mayor a 500KB.</span>";
                    }
                }
            }
            ?>
        </p>
        <p>
            <button type="submit" name="btnSubir">Subir imagen</button>
            <!--Si le damos a submit, no hay manera de mantener la imagen cargada, por seguridad.-->
        </p>
    </form>
    <?php
    //SI NO HAY ERRORES:
    if (isset($_POST["btnSubir"]) && !$error_archivo) {
        echo "<h1>Respuestas cuando no hay errores y la imagen se ha subido.</h1>";
        echo "<p><strong>Nombre de la imagen seleccionada: </strong>" . $_FILES["foto"]["name"] . "</p>";
        echo "<p><strong>Error en la subida: </strong>" . $_FILES["foto"]["error"] . "</p>";
        echo "<p><strong>Ruta del archivo temporal: </strong>" . $_FILES["foto"]["tmp_name"] . "</p>";
        echo "<p><strong>Tamaño del archivo: </strong>" . $_FILES["foto"]["size"] . " B</p>";
        echo "<p><strong>Tipo de archivo: </strong>" . $_FILES["foto"]["type"] . "</p>";

        //Separamos el nombre del archivo de la extensión:
        $array_nombre = explode(".", $_FILES["foto"]["name"]);

        $extension = "";
        //Si la extensión es sólo de una posición, es que no tiene extensión.
        //Concatenamos un "." con el $array_nombre.
        if (count($array_nombre) > 1) {
            $extension = "." . strtolower(end($array_nombre));
        }
        //La extensión será la última posición del array:
        $extension = end($array_nombre);

        //uniqid() genera un número único.
        $nombre_unico = "img_" . md5(uniqid(uniqid(), true));

        //Unificamos el nombre único con la extensión.
        $nombre_nuevo_archivo = $nombre_unico . $extension;

        //Almacenamos el archivo en una ruta en concreto.
        //Con el arroba quitamos el "Warning" en la página.
        @$var = move_uploaded_file($_FILES["foto"]["tmp_name"], "images/" . $nombre_nuevo_archivo);

        if (!$var) {
            echo "<p>La imagen no ha posidio ser movida por falta de permisos.</p>";
        } else {
            echo "<h3>La imagen ha sido subida con éxito</h3>";
            echo "<img height = '200' src='images/" . $nombre_nuevo_archivo . "'/>";
        }
    }

    //sudo chmod 777 -R RUTA 
    //Para dar permisos recursivamente a todas las carpetas para meter imágenes.
    ?>

    <body>

</html>
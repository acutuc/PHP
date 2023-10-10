<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recogida de Datos</title>
</head>

<body>
    <h1>Recogiendo los datos</h1>
    <?php
    if ($_FILES["foto"]["error"]) {
        echo "<p><strong>Nombre: </strong>" . $_POST["nombre"] . "</p>";
        echo "<p><strong>Apellidos </strong>" . $_POST["apellidos"] . "</p>";
        echo "<p><strong>Contraseña: </strong>" . $_POST["clave"] . "</p>";
        echo "<p><strong>DNI: </strong>" . $_POST["dni"] . "</p>";
        echo "<p><strong>Sexo: </strong>" . $_POST["sexo"] . "</p>";


        echo "<p><strong>Nacido: </strong>" . $_POST["nacido"] . "</p>";

        echo "<p><strong>Comentarios: </strong>" . $_POST["comentarios"] . "</p>";
        if (isset($_POST["subscripcion"])) {
            echo "<p><strong>Subscripción:</strong>Si</p>";
        } else {
            echo "<p><strong>Subscripción:</strong>No</p>";
        }
    } else {
        //Cambiamos nombre y movemos el archivo:
        $nombre_nuevo = md5(uniqid(uniqid(), true));
        $array_nombre = explode(".", $_FILES["foto"]["name"]);
        $extension = "";
        if (count($array_nombre) > 1) {
            $extension = "." . end($array_nombre);
        }
        $nombre_nuevo .= $extension;

        //MOVER EL ARCHIVO: 
        @$var = move_uploaded_file($_FILES["foto"]["tmp_name"], "src/" . $nombre_nuevo);

        if ($var) {
            echo "<p><strong>Nombre: </strong>" . $_POST["nombre"] . "</p>";
            echo "<p><strong>Apellidos </strong>" . $_POST["apellidos"] . "</p>";
            echo "<p><strong>Contraseña: </strong>" . $_POST["clave"] . "</p>";
            echo "<p><strong>DNI: </strong>" . $_POST["dni"] . "</p>";
            echo "<p><strong>Sexo: </strong>" . $_POST["sexo"] . "</p>";
            echo "<p><strong>Foto: </strong><img src='src/" . $nombre_nuevo . "' alt='Foto' title='Foto'/></p>";


            echo "<p><strong>Nacido: </strong>" . $_POST["nacido"] . "</p>";

            echo "<p><strong>Comentarios: </strong>" . $_POST["comentarios"] . "</p>";
        } else {
            echo "<p><strong>Nombre: </strong>" . $_POST["nombre"] . "</p>";
            echo "<p><strong>Apellidos </strong>" . $_POST["apellidos"] . "</p>";
            echo "<p><strong>Contraseña: </strong>" . $_POST["clave"] . "</p>";
            echo "<p><strong>DNI: </strong>" . $_POST["dni"] . "</p>";
            echo "<p><strong>Sexo: </strong>" . $_POST["sexo"] . "</p>";

            echo "<p><strong>Nacido: </strong>" . $_POST["nacido"] . "</p>";

            echo "<p><strong>Comentarios: </strong>" . $_POST["comentarios"] . "</p>";
            echo "<p>No se ha podido mover la imagen a la carpeta destino en el servidor.</p>";
        }

        if (isset($_POST["subscripcion"])) {
            echo "<p><strong>Subscripción:</strong>Si</p>";
        } else {
            echo "<p><strong>Subscripción:</strong>No</p>";
        }
    }

    ?>
</body>

</html>
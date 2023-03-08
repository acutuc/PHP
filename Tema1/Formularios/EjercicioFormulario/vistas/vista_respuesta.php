<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actividad Formulario RESPUESTAS</title>
</head>
<body>
    <h1>Respuestas del formulario</h1>
    <?php
        echo "<p><strong>Nombre: </strong>".$_POST["nombre"]."</p>";
        echo "<p><strong>Usuario: </strong>".$_POST["usuario"]."</p>";
        echo "<p><strong>Contraseña: </strong>".$_POST["contrasenia"]."</p>";
        echo "<p><strong>DNI: </strong>".$_POST["dni"]."</p>";
        if(isset($_POST["sexo"])){
            echo "<p><strong>Sexo: </strong>".$_POST["sexo"]."</p>";
        }
        if(isset($_POST["suscripcion"])){
            echo "<p><strong>Suscripción: </strong>Aceptada</p>";
        }else{
            echo "<p><strong>Suscripción: </strong>No aceptada</p>";
        }
        if($_FILES["foto"]["name"]==""){
            echo "<p><strong>Foto: </strong> foto no seleccionada</p>";
        }else{
            echo "<h2>Información de la imagen seleccionada</h2>";
            echo "<p><strong>Nombre de la imagen seleccionada: </strong>".$_FILES["foto"]["name"]."</p>";
            echo "<p><strong>Error en la subida: </strong>".$_FILES["foto"]["error"]."</p>";
            echo "<p><strong>Ruta del archivo temporal: </strong>".$_FILES["foto"]["tmp_name"]."</p>";
            echo "<p><strong>Tamaño del archivo: </strong>".$_FILES["foto"]["size"]." B</p>";
            echo "<p><strong>Tipo de archivo: </strong>".$_FILES["foto"]["type"]."</p>";

            $array_nombre = explode(".", $_FILES["foto"]["name"]);
            $extension = "";
            if(count($array_nombre) > 1){
                $extension = ".".strtolower(end($array_nombre));
            }
            $nombre_unico="img_".md5(uniqid(uniqid(), true));
            $nombre_nuevo_archivo = $nombre_unico.$extension;

            @$var = move_uploaded_file($_FILES["foto"]["tmp_name"], "images/".$nombre_nuevo_archivo);

            if(!$var){
                echo "<p>La imagen no ha podido ser movida por falta de permisos.</p>";
            }else{
                echo "<p>La imagen ha sido subida con éxito</p>";
                echo "<img heigh='200' src='images/".$nombre_nuevo_archivo."'/>";
            }
        }
    ?>
</body>
</html>
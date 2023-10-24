<?php
if (isset($_POST["btnEnviar"])) {
    $error_fichero = $_FILES["fichero"]["size"] > 1000000 || $_FILES["fichero"]["name"] == "" || $_FILES["fichero"]["error"];
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Ejercicio 2</title>
    <meta charset="UTF-8">
</head>

<body>
    <p>
        Realizar una página php con nombre ejercicio2.php, que te permita subir
        un fichero txt no más grande de 1MB.
        Si el fichero es subido con éxito, será movido con el nombre de
        “archivo.txt” a una carpeta llamada “Ficheros”.
        Informar de los posibles errores y cuándo no los haya, del resultado de la
        operación ( Archivo subido o no con Éxito)
    </p>
    <form action="ejercicio2.php" method="post" enctype="multipart/form-data">
        <input type="file" name="fichero" id="fichero">
        <p>
            <button type="submit" name="btnEnviar" accept="text/*">Enviar</button>
        </p>

    </form>
    <?php
    if(isset($_POST["btnEnviar"]) && $error_fichero){
        if($_FILES["fichero"]["name"] == ""){
            echo "<p>Debe seleccionar un fichero</p>";
        }else{
            echo "<p>Ha habido un error al subir el fichero</p>";
        }
    }
    if (isset($_POST["btnEnviar"]) && !$error_fichero) {
        @$var = move_uploaded_file($_FILES["fichero"]["tmp_name"], "Ficheros/archivo.txt");

        if (!$var) {
            echo "<p>El fichero no ha podido ser movido por falta de permisos.</p>";
        } else {
            echo "<p>El fichero <strong>archivo.txt</strong> ha sido subido con éxito</p>";
        }
    }

    ?>
</body>

</html>
<?php
function mi_strlen($texto)
{
    $contador = 0;
    while (isset($texto[$contador])) {
        $contador++;
    }
    return $contador;
}


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Ejercicio 1</title>
    <meta charset="UTF-8">
</head>

<body>
    <p>
        Realizar una página php con nombre ejercicio1.php, que contenga un
        formulario con un campo de texto y un botón. Este botón al pulsarse, nos
        va a modificar la página respondiendo cuántos caracteres se han
        introducido en el cuadro de texto.
    </p>
    <form action="ejercicio1.php" method="post" enctype="multipart/form-data">
        <input type="text" id="texto" name="texto" value="<?php if (isset($_POST["texto"])) echo $_POST["texto"] ?>">
        <p>
            <button type="submit" name="btnEnviar">Enviar</button>
        </p>
    </form>

    <?php
    if (isset($_POST["btnEnviar"])) {

        echo "<p><strong>El texto introducido tiene: </strong>" . mi_strlen($_POST["texto"]) . "</p>";
    }
    ?>
</body>

</html>
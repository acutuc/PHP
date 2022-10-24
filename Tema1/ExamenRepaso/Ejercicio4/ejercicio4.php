<?php
if (isset($_POST["btnEnviar"])) {
    $error_fichero = $_FILES["fichero"]["size"] > 1000000 || $_FILES["fichero"]["name"] == "" || $_FILES["fichero"]["error"];
    if (!$error_fichero) {
        @$var = move_uploaded_file($_FILES["fichero"]["tmp_name"], "Horario/horarios.txt");
    }
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
    <?php
    @$fd = fopen("Horario/horarios.txt", "r");

    if (!$fd) {
        echo "<h2>No se encuentra el archivo <em>Horario/horarios.txt</em></h2>";
        echo "<form action='ejercicio4.php' method='post' enctype='multipart/form-data'>";
        echo "<label for='fichero'>Seleccione un archivo .txt no superior a 1MB </label>";
        echo "<input type='file' accept='text/plain id='fichero' name='fichero'>";

        if (isset($_POST["btnEnviar"]) && $error_fichero) {
            if ($_FILES["fichero"]["name"] == "") {
                echo "<p>Debe seleccionar un fichero</p>";
            } else {
                echo "<p>Ha habido un error al subir el fichero</p>";
            }
        }

        echo "<p><input type='submit' name='btnEnviar' value='Subir'></p>";
        echo "</form>";
        if (isset($_POST["btnEnviar"]) && !$error_fichero) {
            echo "<p>No se ha podido subir el archivo a <em>Horario/horarios.txt</em></p>";
        }
    } else {
    ?>
        <form action="ejercicio4.php" method="post" enctype="multipart/form-data">
            <label for="profesor">Seleccione un profesor: </label>
            <select id="profesor" name="profesor">
                <?php
                while ($linea = fgets($file)) {
                    $fila_datos = mi_explode("\t", $linea);
                    if (isset($_POST["profesor"]) && $_POST["profesor"] == $fila_datos[0]) {
                        echo "<option selected value='" . $fila_datos[0] . "'>".$fila_datos[0]."</option>";
                        $profesor=$fila_datos[0];
                    } else {
                        echo "<option value='" . $fila_datos[0] ."'>" . $fila_datos[0] . "</option>";
                    }
                }
                ?>
            </select>
            <button type="submit" name="btnVerHorario">Ver horario</button>
        </form>
    <?php
        if (isset($_POST["btnVerHorario"])) {
            echo "<h3 align='center'>Horario del Profesor: " . $profesor . "</h3>";
            echo "dibujar la tabla";
        }
        fclose($file);
    }

    ?>
</body>

</html>
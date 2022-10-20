<?php
if (isset($_POST["btnGenerar"])) {

    $error_formulario = $_POST["num"] == "" || !is_numeric($_POST["num"]) || $_POST["num"] < 1 || $_POST["num"] > 10;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Ejercicio 1 Ficheros</title>
    <meta charset="UTF-8">
</head>

<body>
    <h1>Ejercicio 1 Ficheros</h1>
    <p>
        Realizar una web con un formulario que pida un número entero entre 1 y 10 y
        guarde en una carpeta con nombre Tablas en un fichero con el nombre
        tabla_n.txt la tabla de multiplicar de ese número, done n es el número
        introducido.
    </p>
    <form action="index.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="num">Introduzca un número entre 1 y 10 (ambos inclusive):</label>
            <input type="text" name="num" id="num" value="<?php if (isset($_POST["num"])) echo $_POST["num"] ?>">
            <?php
            if (isset($_POST["btnGenerar"]) && $error_formulario) {
                if ($_POST["num"] == "") {
                    echo "<span class='error'>* Campo vacío *</span>";
                } else {
                    echo "<span class='error'>* No has introducido un número entre 1 y 10 *</span>";
                }
            }
            ?>
        </p>
        <p>
            <button type="submit" name="btnGenerar">Generar</button>
        </p>
    </form>
    <?php
    if (isset($_POST["btnGenerar"]) && !$error_formulario) {
        echo "<h2>Ejercicio realizado</h2>";

        @$fd = fopen("tablas/tabla_" . $_POST["num"] . ".txt", "w");

        //PONEMOS LOS PERMISOS. sudo chmod 777 -R (ruta)
        if (!$fd) {
            die("<p>No se ha podido crear el fichero 'tabla_" . $_POST["num"] . ".txt'</p>");
        }

        for ($i = 1; $i <= 10; $i++) {
            fwrite($fd, $i . " * " . $_POST["num"] . " = " . $i * $_POST["num"] . PHP_EOL);
        }

        fclose($fd);

        echo "<h2>Archivo generado con éxito: <a href='tablas/tabla_" . $_POST["num"] . ".txt'>tabla_" . $_POST["num"] . ".txt</a></h2>";
    }
    ?>
</body>

</html>
<?php
if (isset($_POST["btnEnviar"])) {
    $error_formulario = $_POST["num"] == "" || !is_numeric($_POST["num"]) || $_POST["num"] <= 0 || $_POST["num"] > 10;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .error {
            color: red;
        }

        .success {
            color: blue;
        }
    </style>
    <title>Ejercicio 1</title>
</head>

<body>
    <h1>Ejercicio 1</h1>
    <p>
        Realizar una web con un formulario que pida un número entero entre 1 y 10 y
        guarde en una carpeta con nombre Tablas en un fichero con el nombre
        tabla_n.txt la tabla de multiplicar de ese número, done n es el número
        introducido.
    </p>

    <form method="post" action="ejercicio1.php">
        <p>
            <label for="num">Introduzca un número del 1 al 10 (ambos inclusive): </label><input type="text" name="num" id="num" value="<?php if (isset($_POST["num"])) echo $_POST["num"] ?>">
        </p>
        <?php
        if (isset($_POST["btnEnviar"]) && $error_formulario) {
            if ($_POST["num"] == "") {
                echo "<span class='error'>**Campo vacío**</span>";
            } else {
                echo "<span class='error'>No has introducido un número correcto</span>";
            }
        }
        ?>
        <p>
            <button type="submit" name="btnEnviar">Crear fichero</button>
        </p>
    </form>
    <?php
    if (isset($_POST["btnEnviar"]) && !$error_formulario) {
        $nombre_fichero = "tabla_" . $_POST["num"] . ".txt";
        @$fd = fopen("../Tablas/" . $nombre_fichero, "w");

        if (!$fd) {
            die("<p>No se ha podido crear el fichero 'Tablas/" . $nombre_fichero . "'</p>");
        }

        for ($i = 1; $i <= 10; $i++) {
            fputs($fd, $i . " x " . $_POST["num"] . " = " . $i * $_POST["num"] . PHP_EOL);
        }

        fclose($fd);

        echo "<p><span class='success'>Fichero generado con éxito</span></p>";
    }
    ?>
</body>

</html>
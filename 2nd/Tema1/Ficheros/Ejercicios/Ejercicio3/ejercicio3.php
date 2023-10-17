<?php
if (isset($_POST["btnEnviar"])) {
    $error_num1 = $_POST["num1"] == "" || !is_numeric($_POST["num1"]) || $_POST["num1"] <= 0 || $_POST["num1"] > 10;
    $error_num2 = $_POST["num2"] == "" || !is_numeric($_POST["num2"]) || $_POST["num2"] <= 0 || $_POST["num2"] > 10;

    $error_formulario = $error_num1 || $error_num2;
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
    <title>Ejercicio 3</title>
</head>

<body>
    <h1>Ejercicio 3</h1>
    <p>
        Realizar una web con un formulario que pida dos números n y m entre 1 y 10,
        lea el fichero tabla_n.txt con la tabla de multiplicar de ese número de la
        carpeta Tablas, y muestre por pantalla la línea m del fichero. Si el fichero no
        existe debe mostrar un mensaje informando de ello.
    </p>

    <form method="post" action="ejercicio3.php">
        <p>
            <label for="num1">Introduzca un número del 1 al 10 (ambos inclusive): </label><input type="text" name="num1" id="num1" value="<?php if (isset($_POST["num1"])) echo $_POST["num1"] ?>">
        </p>
        <?php
        if (isset($_POST["btnEnviar"]) && $error_num1) {
            if ($_POST["num1"] == "") {
                echo "<span class='error'>**Campo vacío**</span>";
            } else {
                echo "<span class='error'>No has introducido un número correcto</span>";
            }
        }
        ?>
        <p>
            <label for="num2">Introduzca un número del 1 al 10 (ambos inclusive): </label><input type="text" name="num2" id="num2" value="<?php if (isset($_POST["num2"])) echo $_POST["num2"] ?>">
        </p>
        <?php
        if (isset($_POST["btnEnviar"]) && $error_num2) {
            if ($_POST["num2"] == "") {
                echo "<span class='error'>**Campo vacío**</span>";
            } else {
                echo "<span class='error'>No has introducido un número correcto</span>";
            }
        }
        ?>
        <p>
            <button type="submit" name="btnEnviar">Leer fichero</button>
        </p>
    </form>
    <?php
    if (isset($_POST["btnEnviar"]) && !$error_formulario) {
        $nombre_fichero = "tabla_" . $_POST["num1"] . ".txt";
        @$fd = fopen("../Tablas/" . $nombre_fichero, "r");

        if (!$fd) {
            die("<p>No existe el fichero 'Tablas/" . $nombre_fichero . "'</p>");
        }

        for ($i = 1; $i <= 10; $i++) {
            $linea = fgets($fd);
            if ($i == $_POST["num2"]) {
                echo "<p><span class='success'>" . $linea . "</span></p>";
            }
        }



        fclose($fd);
    }
    ?>
</body>

</html>
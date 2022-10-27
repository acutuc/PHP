<?php
function error_num($num)
{
    return $num == "" || !is_numeric($num) || $num < 1 || $num > 10;
}

if (isset($_POST["btnGenerar"])) {
    $error_formulario = error_num($_POST["num1"]) || error_num($_POST["num2"]);
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Ejercicio 3</title>
    <meta charset="UTF-8">
</head>

<body>
    <p>
        Realizar una web con un formulario que pida dos números n y m entre 1 y 10,
        lea el fichero tabla_n.txt con la tabla de multiplicar de ese número de la
        carpeta Tablas, y muestre por pantalla la línea m del fichero. Si el fichero no
        existe debe mostrar un mensaje informando de ello.
    </p>
</body>
<form action="ejercicio3.php" method="post">
    <p>
        <label for="num1">Introduzca un número entre 1 y 10 (ambos inclusive)</label>
        <input type="text" name="num1" id="num1" value="<?php if (isset($_POST["num1"])) echo $_POST["num1"]; ?>" />
        <?php
        if (isset($_POST["num1"]) && $error_formulario) {
            if ($_POST["num1"] == "")
                echo "<span class='error'>*Campo vacío*</span>";
            else
                echo "<span class='error'>*No has introducido un número correcto*</span>";
        }
        ?>
    </p>
    <p>
        <label for="num2">Introduzca un número entre 1 y 10 (ambos inclusive)</label>
        <input type="text" name="num2" id="num2" value="<?php if (isset($_POST["num2"])) echo $_POST["num2"]; ?>" />
        <?php
        if (isset($_POST["num2"]) && $error_formulario) {

            if ($_POST["num2"] == "")
                echo "<span class='error'>* Campo vacío *</span>";
            else
                echo "<span class='error'>* No has introducido un número correcto *</span>";
        }
        ?>
    </p>
    <p><button type="submit" name="btnGenerar">Generar</button></p>
</form>

<?php
if (isset($_POST["btnGenerar"]) && !$error_formulario) {
    echo "<h2>Ejercicio realizado</h2>";

    @$fd = fopen("tablas/tabla_" . $_POST["num1"] . ".txt", "r");

    if (!$fd) {
        die("<p>No se ha podido leer el fichero 'tabla_" . $_POST["num1"] . ".txt'</p>");
    }

    echo "<h2>" . $_POST["num1"] . " X " . $_POST["num2"] . ": </h2>";

    $i = 1;
    while ($i <= $_POST["num2"]) {

        $linea = fgets($fd);
        $i++;
    }

    echo "<p>" . $linea . "</p>";

    fclose($fd);
}
?>
</html>
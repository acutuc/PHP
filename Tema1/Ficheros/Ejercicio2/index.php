<?php
if (isset($_POST["btnGenerar"])) {

    $error_formulario = $_POST["num"] == "" || !is_numeric($_POST["num"]) || $_POST["num"] < 1 || $_POST["num"] > 10;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Ejercicio 2 Ficheros</title>
    <meta charset="UTF-8">
</head>

<body>
    <h1>Ejercicio 2 Ficheros</h1>
    <p>
        Realizar una web con un formulario que pida un número entero entre 1 y 10,
        lea el fichero tabla_n.txt con la tabla de multiplicar de ese número de la
        carpeta Tablas, done n es el número introducido, y la muestre por pantalla.
        Si el fichero no existe debe mostrar un mensaje informando de ello.
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

        @$fd = fopen("../Ejercicio1/tablas/tabla_" . $_POST["num"] . ".txt", "r");


        if (!$fd) {
            die("<p>El fichero 'tabla_" . $_POST["num"] . ".txt' no existe.</p>");
        }

        //Vamos a la posición 0.
        fseek($fd, 0);
        while ($linea = fgets($fd)) {
            echo "<p>$linea</p>";
        }

        fclose($fd);
    }
    ?>
</body>

</html>
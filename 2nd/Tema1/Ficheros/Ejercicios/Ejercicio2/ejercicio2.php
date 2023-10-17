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
    <title>Ejercicio 2</title>
</head>

<body>
    <h1>Ejercicio 2</h1>
    <p>
        Realizar una web con un formulario que pida un número entero entre 1 y 10,
        lea el fichero tabla_n.txt con la tabla de multiplicar de ese número de la
        carpeta Tablas, done n es el número introducido, y la muestre por pantalla.
        Si el fichero no existe debe mostrar un mensaje informando de ello.
    </p>

    <form method="post" action="ejercicio2.php">
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
            <button type="submit" name="btnEnviar">Leer fichero</button>
        </p>
    </form>
    <?php
    if (isset($_POST["btnEnviar"]) && !$error_formulario) {
        $nombre_fichero = "tabla_" . $_POST["num"] . ".txt";
        @$fd = fopen("../Tablas/" . $nombre_fichero, "r");

        if (!$fd) {
            die("<p>No existe el fichero 'Tablas/" . $nombre_fichero . "'</p>");
        }

        //Mientras tengamos líneas:
        while($linea = fgets($fd)){
            echo "<p><span class='success'>".$linea."</span></p>";
        }

        fclose($fd);
    }
    ?>
</body>

</html>
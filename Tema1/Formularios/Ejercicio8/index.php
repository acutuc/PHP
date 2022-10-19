<?php
if (@$_POST["btnCalcular"] == "reset") {
    $_POST = array();
}

if (isset($_POST["btnCalcular"])) {
    $error_edad = $_POST["edad"] == "" || !is_numeric($_POST["edad"]);
    $error_estudiante = !isset($_POST["estudiante"]);

    $error_formulario = $error_edad || $error_estudiante;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Ejercicio 8</title>
    <meta charset="UTF-8">
</head>

<body>
    <h1>Ejercicio 8</h1>
    <p>
        La empresa "Cinem@s" tiene establecidas diferentes tarifas para las localidades en función de la edad del cliente y de su condición o no de estudiante,
        y que desea que los propios clientes puedan calcular exactamente el importe de sus entradas a través de una sencilla página web.
        Si es estudiante o menor de 12 años el precio de la entrada será 3,5€ para el resto de personas 5€.
        Diseñad un formulario que pida la edad al usuario y dos botones radio que permitan elegir si es estudiante o no.
        Un botón para calcular y otro que permitar borrar. Utilizar el método POST.
    </p>
    <form action="index.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="edad">Introduzca su edad: </label><input type="text" name="edad" id="edad" value="<?php if (isset($_POST["edad"])) echo $_POST["edad"] ?>">
            <?php
            if (isset($_POST["btnCalcular"]) && $error_edad) {
                if ($_POST["edad"] == "") {
                    echo "<span class='error'>*Campo vacío*</span>";
                } else {
                    echo "<span class='error'>*Debe introducir un valor numérico*</span>";
                }
            }
            ?>
        </p>
        <p>
            <input type="radio" name="estudiante" id="estudiante" value="estudiante" <?php if (isset($_POST["estudiante"]) && $_POST["estudiante"] == "estudiante") echo "checked" ?>><label for="estudiante"> Estudiante</label><br>
            <input type="radio" name="estudiante" id="no-estudiante" value="no estudiante" <?php if (isset($_POST["estudiante"]) && $_POST["estudiante"] == "no estudiante")  echo "checked" ?>><label for="no-estudiante"> No estudiante</label>
            <?php
            if (isset($_POST["btnCalcular"]) && $error_estudiante) {
                echo "<br>";
                echo "<span class='error'>*Debe marcar una opción</span>";
            }
            ?>
        </p>
        <p>
            <button type="submit" name="btnCalcular" value="submit">Calcular</button>&nbsp;&nbsp;
            <button type="submit" name="btnCalcular" value="reset">Borrar</button>
        </p>
    </form>
    <?php
    if (isset($_POST["btnCalcular"]) && !$error_formulario) {
        echo "<h2>Respuestas:</h2>";
        if ($_POST["edad"] < 12 || $_POST["estudiante"] == "estudiante") {
            echo "<p>El precio de la entrada será de <strong>3,50€</strong></p>";
        } else {
            echo "<p>El precio de la entrada será de <strong>5€</strong></p>";
        }
    }
    ?>

</body>

</html>
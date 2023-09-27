<?php
if (isset($_POST["btnCalcular"])) {
    $error_euros = $_POST["euros"] == "" || !is_numeric($_POST["euros"]);
    $error_monedas = !isset($_POST["tipo-moneda"]);

    $error_formulario = $error_euros || $error_monedas;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Ejercicio 7</title>
    <meta charset="UTF-8">
</head>

<body>
    <h1>Ejercicio 7</h1>
    <p>
        Hacer un conversor de euros a pesetas o dolares. El usuario podrá elegir la moneda mediante bonotes de tipo radio. Utilizar el método POST. Realizar el código en un único documento PHP.
    </p>
    <form action="index.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="euros">Introduzca un valor en euros: </label><input type="text" id="euros" name="euros" value="<?php if (isset($_POST["euros"])) echo $_POST["euros"] ?>">
            <?php
            if (isset($_POST["btnCalcular"]) && $error_euros) {
                if ($_POST["euros"] == "") {
                    echo "<span class='error'>*Campo vacío*</span>";
                } else {
                    echo "<span class='error'>*Debe introducir un valor numérico*</span>";
                }
            }
            ?>
        </p>
        <p>
            <label for="tipo-moneda">Elija a qué moneda convertir:</label><br>
            <input type="radio" name="tipo-moneda" id="dolares" value="dolares" <?php if (isset($_POST["tipo-moneda"]) && $_POST["tipo-moneda"] == "dolares") echo "checked" ?>><label for="dolares">Dólares</label><br>
            <input type="radio" name="tipo-moneda" id="pesetas" value="pesetas" <?php if (isset($_POST["tipo-moneda"]) && $_POST["tipo-moneda"] == "pesetas") echo "checked" ?>><label for="pesetas">Pesetas</label><br>
            <?php
            if (isset($_POST["btnCalcular"]) && $error_monedas) {
                echo "<span class='error'>*Debe seleccionar un tipo de moneda*</span>";
            }
            ?>
        </p>
        <p>
            <button type="submit" name="btnCalcular">Calcular</button>
        </p>
    </form>
    <?php
    if (isset($_POST["btnCalcular"]) && !$error_formulario) {
        echo "<h2>Respuestas</h2>";
        if ($_POST["tipo-moneda"] == "dolares") {
            echo "<p><strong>" . $_POST["euros"] . "€</strong> equivale a: <strong>" . $_POST["euros"] * 0.98 . "$</strong></p>";
        } else {
            echo "<p><strong>" . $_POST["euros"] . "€</strong> equivale a: <strong>" . $_POST["euros"] * 166 . " pesetas</strong></p>";
        }
    }

    ?>
</body>

</html>
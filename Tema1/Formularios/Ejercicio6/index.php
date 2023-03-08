<?php
if (isset($_POST["btnCalcular"])) {
    $error_euros = $_POST["euros"] == "" || !is_numeric($_POST["euros"]);
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Ejercicio 6</title>
    <meta charset="UTF-8">
</head>

<body>
    <h1>Ejercicio 6</h1>
    <p>
        Hacer un conversor de euros a pesetas. Utilizar el método POST. Se ha de crear el código en un único documento PHP.
    </p>
    <form action="index.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="euros">Introduzca un valor en euros: </label><input type="text" id="euros" name="euros" value="<?php if (isset($_POST["euros"])) echo $_POST["euros"] ?>">
            <?php
            if (isset($_POST["btnCalcular"]) && $error_euros) {
                if ($_POST["euros"] == "") {
                    echo "<span class='error'>*Campo vacío*</span>";
                } else {
                    echo "<span class='error'>*Introduzca un valor numérico*</span>";
                }
            }
            ?>
        </p>
        <p>
            <button type="submit" name="btnCalcular">Calcular</button>
        </p>
    </form>
    <?php
    if (isset($_POST["btnCalcular"]) && !$error_euros) {
        echo "<h2>Respuesta:</h2>";
        echo "<p><strong>" . $_POST["euros"] . "€</strong> equivale a: <strong>" . $_POST["euros"] * 166 . "</strong> pesetas.</p>";
    }
    ?>
</body>

</html>
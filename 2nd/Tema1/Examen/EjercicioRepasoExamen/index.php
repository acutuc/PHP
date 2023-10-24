<?php
if (isset($_POST["btnComprobar"])) {
    $error_form = $_POST["palabra"] == "";
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio exámen</title>
    <style>
        .error {
            color: red
        }
    </style>
</head>

<body>
    <h1>Ejercicio exámen</h1>
    <form method="post" action="index.php">
        <p>
            <label for="palabra">Escriba una palabra y compruebe si tiene algún caracter repetido: </label>
            <input type="text" id="palabra" name="palabra" value="<?php if (isset($_POST["palabra"])) echo $_POST["palabra"] ?>">
            <?php
            if (isset($_POST["btnComprobar"]) && $error_form) {
                echo "<span class='error'>**Campo vacío**</span>";
            }
            ?>
        </p>
        <p>
            <button type="submit" name="btnComprobar">Comprobar</button>
        </p>
    </form>

    <?php
    if (isset($_POST["btnComprobar"])&& !$error_form) {
        echo "<h3>Respuesta</h3>";
        $bool = false;

        for ($i = 1; $i < strlen($_POST["palabra"]); $i++) {

            for ($j = 0; $j < $i; $j++) {
                if ($_POST["palabra"][$i] == $_POST["palabra"][$j]) {
                    $bool = true;
                    break;
                }
            }
        }

        if ($bool) {
            echo "<p>La palabra contiene un carácter repetido</p>";
        } else {
            echo "<p>No hay ningun carácter repetido en la palabra</p>";
        }
        explode()
    }
    ?>
</body>

</html>
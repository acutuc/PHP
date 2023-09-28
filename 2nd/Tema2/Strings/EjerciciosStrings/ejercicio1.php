<?php
if (isset($_POST["btnComparar"])) {
    //Se envía el formulario. Vemos si hay errores.
    $error_primera_palabra = strlen($_POST["primera_palabra"]) < 3;
    $error_segunda_palabra = strlen($_POST["segunda_palabra"]) < 3;
    $error_formulario = $error_primera_palabra || $error_segunda_palabra;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Ejercicio 1</title>
    <meta charset="UTF-8">
    <style>
        .fondo {
            background-color: lightblue;
            border: 2px solid black;
            padding: 5px;
        }

        #comparar {
            align: center;
        }

        .error {
            color: red;
        }

        .verde {
            background-color: lightgreen;
            border: 2px solid black;
            margin: 1rem 0;
            padding: 5px;
        }
    </style>
</head>

<body>
    <div class="fondo">
        <h2 align="center">Ripios - Formulario</h2>
        <form method="POST" action="ejercicio1.php">
            <p>Dime dos palabras y te diré si riman o no.</p>
            <p><label for="primera">Primera palabra: </label><input type="text" id="primera" name="primera_palabra" value="<?php if (isset($_POST['primera_palabra'])) echo $_POST['primera_palabra'] ?>" />
                <?php
                if (isset($_POST["primera_palabra"]) && $error_primera_palabra) {
                    if ($_POST["primera_palabra"] == "")
                        echo "<span class = 'error'>***Campo vacío***</span>";
                    else
                        echo "<span class = 'error'>***Teclee al menos 3 caracteres***</span>";
                }
                ?>
            </p>
            <p><label for="segunda">Segunda palabra: </label><input type="text" id="segunda" name="segunda_palabra" value="<?php if (isset($_POST['segunda_palabra'])) echo $_POST['segunda_palabra'] ?>" />
                <?php
                if (isset($_POST["segunda_palabra"]) && $error_segunda_palabra) {
                    if ($_POST["segunda_palabra"] == "")
                        echo "<span class = 'error'>***Campo vacío***</span>";
                    else
                        echo "<span class = 'error'>***Teclee al menos 3 caracteres***</span>";
                }
                ?>
            </p>
            <button type="submit" name="btnComparar" id="comparar">Comparar</button>
        </form>
    </div>
    <?php
    //Si rellenamos el formulario y no hay errores:
    if (isset($_POST["btnComparar"]) && !$error_formulario) {
    ?>
        <div class="verde">
            <h2 align="center">Ripios - Resultados</h2>
            <?php
            if ($_POST["primera_palabra"][strlen($_POST["primera_palabra"]) - 3] == $_POST["segunda_palabra"][strlen($_POST["segunda_palabra"]) - 3] && $_POST["primera_palabra"][strlen($_POST["primera_palabra"]) - 2] == $_POST["segunda_palabra"][strlen($_POST["segunda_palabra"]) - 2] && $_POST["primera_palabra"][strlen($_POST["primera_palabra"]) - 1] == $_POST["segunda_palabra"][strlen($_POST["segunda_palabra"]) - 1]) {
                echo "<p><strong>" . $_POST['primera_palabra'] . "</strong> y <strong>" . $_POST['segunda_palabra'] . "</strong> riman.</p>";
            } else if ($_POST["primera_palabra"][strlen($_POST["primera_palabra"]) - 2] == $_POST["segunda_palabra"][strlen($_POST["segunda_palabra"]) - 2] && $_POST["primera_palabra"][strlen($_POST["primera_palabra"]) - 1] == $_POST["segunda_palabra"][strlen($_POST["segunda_palabra"]) - 1]) {
                echo "<p><strong>" . $_POST['primera_palabra'] . "</strong> y <strong>" . $_POST['segunda_palabra'] . "</strong> riman un poco.</p>";
            } else {
                echo "<p><strong>" . $_POST['primera_palabra'] . "</strong> y <strong>" . $_POST['segunda_palabra'] . "</strong> no riman.</p>";
            }

            ?>
        <?php
    }
        ?>
        </div>


</body>

</html>
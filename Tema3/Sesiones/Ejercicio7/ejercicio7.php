<?php
session_name("ejercicio7");
session_start();
if (!isset($_SESSION["numero"]))
    $_SESSION["numero"] = 1;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ejercicio 7</title>
    <style>
        button {
            height: 2rem;
            width: auto;
        }

        #dados {
            font-size: 4rem;
        }
    </style>
</head>

<body>
    <h2>TIRADA DE DADOS</h2>

    <?php

    if (isset($_SESSION["btnMover"]) && $_SESSION["btnMover"] == "tirar") {

        echo "<p id='dados'>";
        for ($i = 0; $i < $_SESSION["numero"]; $i++) {
            $random = rand(1, 6);

            switch ($random) {
                case 1:
                    echo "&#9856; ";
                    break;

                case 2:
                    echo "&#9857; ";
                    break;

                case 3:
                    echo "&#9858; ";
                    break;

                case 4:
                    echo "&#9859; ";
                    break;

                case 5:
                    echo "&#9860; ";
                    break;

                default:
                    echo "&#9861; ";
                    break;
            }
        }

        echo "</p>";
        $_SESSION["btnMover"] = "no-tirar";
    }
    ?>


    <form action="ejercicio7_2.php" method="post">
        <p>Haga click en los botones para aumentar o disminuir el número de dados o para volver a tirarlos:</p>

        <div id="todo">

            <p>
                <button type="submit" name="btnMover" value="sumar"> - </button>

                <?php echo $_SESSION["numero"] ?>

                <button type="submit" name="btnMover" value="restar"> + </button>
            </p>

            <button type="submit" name="btnMover" value="tirar">Tirar dados</button>
        </div>
    </form>

</body>

</html>
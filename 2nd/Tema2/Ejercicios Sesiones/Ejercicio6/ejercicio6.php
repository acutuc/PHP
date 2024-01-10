<?php
session_name("ejercicio6");
session_start();
if (!isset($_SESSION["pos_azul"]))
    $_SESSION["pos_azul"] = 0;
if (!isset($_SESSION["pos_naranja"]))
    $_SESSION["pos_naranja"] = 0;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ejercicio 6</title>
    <style>
        button {
            height: 2rem;
            width: auto;
        }

        #azul {
            color: skyblue
        }

        #naranja {
            color: orange
        }
    </style>
</head>

<body>
    <h2>VOTAR UNA OPCIÓN</h2>
    <form action="ejercicio6_2.php" method="post">
        <p>Haga click en los botones para votar por una opción:</p>

        <div id="contenedor">

            <p>
                <button id="azul" type="submit" name="btnMover" value="azul">&#x2714;</button>
                <svg version="1.1" xmlns=http://www.w3.org/2000/svg width="<?php echo $_SESSION["pos_azul"] ?>px" height="20px">
                    <line x1="-300" y1="10" x2="300" y2="10" stroke="skyblue" stroke-width="20" />
                </svg>
                <br />
                <br />
                <button id="naranja" type="submit" name="btnMover" value="naranja">&#x2714;</button>

                <svg version="1.1" xmlns=http://www.w3.org/2000/svg width="<?php echo $_SESSION["pos_naranja"] ?>px" height="20px">
                    <line x1="-300" y1="10" x2="300" y2="10" stroke="orange" stroke-width="20" />
                </svg>
            </p>

            <button type="submit" name="btnMover" value="cero">Poner a cero</button>
        </div>
    </form>
</body>

</html>
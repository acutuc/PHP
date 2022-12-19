<?php
session_name("ejercicio5");
session_start();
if (!isset($_SESSION["pos_x"]))
    $_SESSION["pos_x"] = 0;

if (!isset($_SESSION["pos_y"]))
    $_SESSION["pos_y"] = 0;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ejercicio5</title>
    <style>
        * {
            box-sizing: border-box;
        }

        div#contenedor{
            display:flex;
            align-items: center;
        }

        div#manos{
            display:flex;
            flex-flow: row wrap;
            justify-content: center;
        }

        div#manos > div.solo{
            width: 100%;
            text-align: center;
            margin:1rem;
        }

        button{
            font-size: 30px;
        }

        p > svg{
            border:2px solid black;
        }
    </style>
</head>

<body>
    <h2>MOVER UN PUNTO A DERECHA E IZQUIERDA</h2>
    <form action="ejercicio5_2.php" method="post">
        <p>Haga click en los botones para mover el punto:</p>

        <div id="contenedor">

            <div id="manos">
                <div class="solo">
                    <button type="submit" name="btnMover" value="arriba">&#x1F446;</button>
                </div>
                <div>
                    <button type="submit" name="btnMover" value="izquierda">&#x1F448;</button>
                </div>
                <div>
                    <button type="submit" name="btnReset" id="volver">Volver al centro</button>
                </div>
                <div>
                    <button type="submit" name="btnMover" value="derecha">&#x1F449;</button>
                </div>
                <div class="solo">
                    <button type="submit" name="btnMover" value="abajo">&#x1F447;</button>
                </div>
            </div>


            <p>
                <svg version="1.1" xmlns=http://www.w3.org/2000/svg width="400px" height="400px" viewbox="-200 -200 400 400">
                    <circle cx="<?php echo $_SESSION["pos_x"] ?>" cy="<?php echo $_SESSION["pos_y"] ?>" r="8" fill="red" />
                </svg>
            </p>

        </div>

    </form>
</body>

</html>
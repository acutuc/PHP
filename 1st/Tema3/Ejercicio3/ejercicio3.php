<?php
session_name("ejercicio3");
session_start();
if (!isset($_SESSION["contador"]))
    $_SESSION["contador"] = 0;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ejercicio 3</title>
</head>

<body>
    <h2>SUBIR Y BAJAR NUMERO</h2>
    <form action="ejercicio3_2.php" method="post">
        <p>Haga click en los botones para modificar el valor:</p>
        <p>
            <?php
            if (isset($_SESSION["error"])) {
                echo "<span class='error'>" . $_SESSION["error"] . "</span>";
                unset($_SESSION["error"]);
            }
            ?>
        </p>
        <p id="numero">
            <button type="submit" name="btnRestar">-</button>
            <span><?php echo $_SESSION["contador"]?></span>
            <button type="submit" name="btnSumar">+</button>
        </p>
        <p>
            <button type="submit" name="btnReset">Poner a cero</button>
        </p>
    </form>
</body>

</html>
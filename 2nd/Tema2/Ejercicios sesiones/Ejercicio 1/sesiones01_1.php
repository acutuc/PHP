<?php
session_name("Ejercicio1");
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ejercicio 1</title>
    <style>
        span.error{
            color:red;
        }
    </style>
</head>

<body>
    <h2>FORMULARIO NOMBRE 1 (FORMULARIO)</h2>
    <form action="sesiones01_2.php" method="post">
        <?php
        if (isset($_SESSION["nombre"]))
            echo "<p>Su nombre es: <strong>" . $_SESSION['nombre'] . "</strong></p>"
        ?>
        <p>Escriba su nombre</p>
        <p>
            <label for="nombre"><strong>Nombre: </strong></label>
            <input type="text" name="nombre" id="nombre" />
            <?php
            if (isset($_SESSION["error"])) {
                echo "<span class='error'>" . $_SESSION["error"] . "</span>";
                unset($_SESSION["error"]);
            }
            ?>
        </p>
        <p>
            <button type="submit" name="btnSiguiente">Siguiente</button>
            <button type="submit" name="btnBorrar">Borrar</button>
        </p>
    </form>
</body>

</html>
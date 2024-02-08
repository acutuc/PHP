<?php
    require "../src/funciones_ctes.php";
    require "../src/seguridad.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen Final PHP</title>
</head>

<body>
    <h1>Examen Final PHP</h1>
    <form method="post" action="index.php">
        Bienvenido <strong><?php echo $datos_usu_log->usuario ?></strong>
        <p>
            <button name="btnSalir">Salir</button>
        </p>
    </form>
</body>

</html>
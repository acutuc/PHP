<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .linea {
            background: none;
            border: none;
            color: blue;
            text-decoration: underline;
            cursor: pointer;
        }
    </style>
    <title>Práctica Rec 2</title>
</head>

<body>
    <h1>Práctica Rec 2</h1>
    <form action="index.php" method="post">
        <p>Bienvenido
            <span class="linea">
                <?php echo $datos_usuario_log["usuario"] ?>
            </span> -
        <form method="post" action="index.php"><button type="submit" name="btnSalir" class="linea">Salir</button></form>
        </p>
    </form>
</body>

</html>
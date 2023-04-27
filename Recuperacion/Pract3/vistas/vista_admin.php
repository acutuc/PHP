<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .enlace {
            border: none;
            background: none;
            color: blue;
            cursor: pointer;
            text-decoration: underline;
        }

        .enlinea {
            display: inline;
        }
    </style>
    <title>Práctica 3</title>
</head>

<body>
    <h1>Práctica 3</h1>
    <div>
        Bienvenido <strong>
            <?php echo $datos_usuario_log->usuario ?>
        </strong> - <form method="post" action="index.php" class="enlinea"><button name="btnSalir"
                class="enlace">Salir</button></form>
        <div>
            <div>

            </div>
</body>

</html>
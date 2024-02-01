<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App Login</title>
    <style>
        .enlace{
            background:none;
            border:none;
            text-decoration: underline;
            color: blue;
            cursor: pointer;
        }
        .enlinea{
            display: inline;
        }
    </style>
</head>

<body>
    <h1>App Login</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usu_log->usuario ?></strong> - <form class="enlinea" action="index.php" method="post">
            <button class="enlace" name="btnSalir">Salir</button>
        </form>
    </div>
</body>

</html>
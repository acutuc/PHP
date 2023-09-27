<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login PDO</title>
</head>

<body>
    <h1>Login PDO</h1>
    <div>
        Bienvenido <strong><?php $datos_usuario_log["usuario"]; ?></strong> -
        <form style="display:inline" action="index.php" method="post">
            <button type="submit" name="btnSalir">Salir</button>
        </form>
    </div>
</body>

</html>
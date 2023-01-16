<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Personal</title>
</head>

<body>
    <h1>Nuevo usuario</h1>
    <form action="registro_usuario.php" method="post">
        <p>
            <label for="nombre"><strong>Nombre: </strong></label><input type="text" id="nombre" name="nombre"
                value="<?php if (isset($_POST["nombre"]))
                    echo $_POST["nombre"] ?>">
            </p>
            <p>
                <label for="nombre"><strong>Usuario: </strong></label><input type="text" id="usuario" name="usuario"
                    value="<?php if (isset($_POST["usuario"]))
                    echo $_POST["usuario"] ?>">
            </p>
            <p>
                <label for="nombre"><strong>Contraseña: </strong></label><input type="password" id="clave" name="clave">
            </p>
            <p>
                <label for="nombre"><strong>Nombre: </strong></label><input type="email" id="email" name="email"
                    value="<?php if (isset($_POST["email"]))
                    echo $_POST["email"] ?>">
            </p>
            <button type="submit" formaction="index.php">Atrás</button>
            <button type="submit" name="btnContinuar">Continuar</button>
        </form>
    </body>

    </html>
<!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Videoclub</title>
        </head>

        <body>
            <h1>Videoclub</h1>
            <form action="index.php" method="post">
                <p>
                    Bienvenido <strong>
                        <?php echo $tupla["usuario"]; ?>
                    </strong> -
                    <button type="submit" name="btnSalir">Salir</button>
                </p>
            </form>
            <h2>Clientes</h2>
            <?php
            if (isset($_SESSION["mensaje_accion"])) {
                echo $_SESSION["mensaje_accion"];

                //Hacemos unset para que no vuelva a salir al recargar:
                unset($_SESSION["mensaje_accion"]);
            }
            ?>
            <p>
                <strong>Foto de perfil:</strong>
                <?php
                echo $tupla["foto"];
                ?>
            </p>
        </body>

        </html>
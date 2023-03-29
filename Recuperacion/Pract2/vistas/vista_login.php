<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .form {
            display: flex;
            justify-content: space-between;
            width: 300px;
        }

        .botones {
            display: flex;
            justify-content: space-around;
            padding-left: 40px;
            width: 200px;
        }

        .error {
            color: red;
        }
    </style>
    <title>Práctica Rec 2</title>
</head>

<body>
    <h1>Práctica Rec 2</h1>
    <form action="index.php" method="post">
        <p class="form">
            <label for="usuario">Usuario: </label><input type="text" id="usuario" name="usuario" value="<?php if (isset($_POST["usuario"]))
                echo $_POST["usuario"] ?>">
                <?php
            if (isset($_POST["btnEntrar"]) && $error_usuario) {
                if ($_POST["usuario"] == "") {
                    echo "<span class='error'>*Campo vacío*</span>";
                } else {
                    echo "<span class='error'>*El usuario no existe*</span>";
                }
            }
            ?>
        </p>
        <p class="form">
            <label for="clave">Contraseña: </label><input type="password" id="clave" name="clave">
            <?php
            if (isset($_POST["btnEntrar"]) && $error_clave) {
                if ($_POST["clave"] == "") {
                    echo "<span class='error'>*Campo vacío*</span>";
                } else {
                    echo "<span class='error>*Contraseña incorrecta*</span>";
                }
            }
            ?>
        </p>
        <p class="botones">
            <button type="submit" name="btnEntrar">Entrar</button><button type="submit"
                name="btnRegistrarse">Registarse</button>
        </p>
    </form>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicio</title>
    <style>
        img {
            height: 100px;
            width: 100px;
        }

        .error {
            color: red;
        }

        .mensaje {
            color: blue;
        }

        .flex {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            padding: 0 50px;
        }

        .elementos {
            width: 30%;
        }
    </style>
</head>

<body>
    <h1>Librería</h1>
    <form method="post" action="index.php">
        <p>
            <label for="usuario">Usuario: </label><input type="text" id="usuario" name="usuario" value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"] ?>" />
            <?php
            if (isset($_POST["btnEntrar"]) && $error_usuario) {
                if ($_POST["usuario"] == "") {
                    echo "<span class='error'>**Campo vacío**</span>";
                } else {
                    echo "<span class='error'>**Usuario o contraseña incorrectos**</span>";
                }
            }
            ?>
        </p>
        <p>
            <label for="clave">Contraseña: </label><input type="password" id="clave" name="clave" />
            <?php
            if (isset($_POST["btnEntrar"]) && $error_clave) {
                echo "<span class='error'>**Campo vacío**</span>";
            }
            ?>
        </p>
        <p>
            <button name="btnEntrar">Entrar</button>
        </p>
    </form>
    <?php
    try {
        $conexion = mysqli_connect(HOSTNAME_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        die("<p>No se ha podido realizar la conexión. Error: " . $e->getMessage() . "</p>");
    }

    try {
        $consulta = "SELECT * FROM libros";
        $resultado = mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        mysqli_close($conexion);
        die("<p>No se ha podido realizar la consulta. Error: " . $e->getMessage() . "</p>");
    }

    if (mysqli_num_rows($resultado) > 0) {
        echo "<h3>Listado de los Libros</h3>";
    } else {
        echo "<h3>No hay libros en la BD.</h3>";
    }

    echo "<div class='flex'>";
    while ($tupla = mysqli_fetch_assoc($resultado)) {
        echo "<div class='elementos'>";

        echo "<img src='Images/" . $tupla["portada"] . "' alt=" . $tupla["titulo"] . "/>";
        echo "<p>" . $tupla["titulo"] . " - " . $tupla["precio"] . "€</p>";

        echo "</div>";
    }
    echo "</div>";

    if (isset($_SESSION["seguridad"])) {
        echo "<p class='mensaje'>" . $_SESSION["seguridad"] . "</p>";
    }
    mysqli_free_result($resultado);
    mysqli_close($conexion);
    ?>
</body>

</html>
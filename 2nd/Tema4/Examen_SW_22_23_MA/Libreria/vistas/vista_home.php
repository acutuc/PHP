<?php
if (isset($_POST["btnEntrar"])) {
    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";

    $error_form = $error_usuario || $error_clave;

    if (!$error_form) {
        //Recogemos los datos:
        $datos["lector"] = $_POST["usuario"]; //lector, porque en la api lo hemos llamado así
        $datos["clave"] = md5($_POST["clave"]);

        $url = DIR_SERV . "/login";
        $respuesta = consumir_servicios_REST($url, "POST", $datos);
        $obj = json_decode($respuesta);

        if (!$obj) {
            session_destroy();
            die(error_page("Librería", $url));
        }

        if (isset($obj->error)) {
            session_destroy();
            die(error_page("Librería", $obj->error));
        }

        if (isset($obj->mensaje)) {
            $error_usuario = true;
        } else {
            //Recogemos en sesiones, además de los datos del usuario y tiempo, la api_session que nos da la api:
            $_SESSION["usuario"] = $datos["lector"];
            $_SESSION["clave"] = $datos["clave"];
            $_SESSION["ultima_accion"] = time();

            $_SESSION["api_session"] = $obj->api_session;

            if ($obj->usuario->tipo == "admin") {
                header("Location:admin/gest_libros.php");
            } else {
                header("Location:index.php");
            }
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Librería</title>
    <style>
        #libros {
            display: flex;
            justify-content: space-between;
            flex-flow: wrap;
            width: 90%;
        }

        #libros div {
            flex: 33% 0;
            text-align: center;
        }

        #libros div img {
            width: 100%;
            height: auto;
        }

        .error {
            color: red;
        }
    </style>
</head>

<body>
    <h1>Librería</h1>
    <form method="post" action="index.php">
        <p>
            <label for="">Nombre de usuario: </label>
            <input type="text" name="usuario" id="usuario" value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"] ?>" />
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
            <label for="clave">Contraseña: </label>
            <input type="password" name="clave" id="clave" />
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
    if (isset($_SESSION["seguridad"])) {
        echo "<p>" . $_SESSION["seguridad"] . "</p>";
        session_destroy();
    }
    ?>
    <h2>Listado de los libros</h2>
    <?php
    $url = DIR_SERV . "/obtenerLibros";
    $respuesta = consumir_servicios_REST($url, "GET");
    $obj = json_decode($respuesta);

    if (!$obj) {
        session_destroy();
        die("<p>Error consumiendo el servicio: " . $url . "</p></body></html>");
    }

    if (isset($obj->error)) {
        session_destroy();
        die("<p>" . $obj->error . "</p></body></html>");
    }

    echo "<div id='libros'>";

    foreach ($obj->libros as $tupla) {
        echo "<div>";
        echo "<img src='images/" . $tupla->portada . "' alt='" . $tupla->titulo . "' title='" . $tupla->titulo . "'/><br>" . $tupla->titulo . " - " . $tupla->precio . "€";
        echo "</div>";
    }

    echo "</div>";


    ?>
</body>

</html>
<?php
if (isset($_POST["btnLoguear"])) {
    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";

    $error_formulario = $error_usuario || $error_clave;

    if (!$error_formulario) {
        //1. Cogemos la URL, que será la dirección de los servicios concatenando el servicio.
        $url = DIR_SERV . "/login";

        //2. Pasamos los índices tal y como se llaman en el servicio:
        $datos_envio["usuario"] = $_POST["usuario"];
        $datos_envio["clave"] = md5($_POST["clave"]);

        //3. Consumimos el servicio, pasando url, método y los datos
        $respuesta = consumir_servicios_rest($url, "POST", $datos_envio);

        //4. Pasamos el json que recibimos a objeto:
        $obj = json_decode($respuesta);

        //Si no hemos obtenido un objeto, el servicio no ha funcionado o algo ha ido mal.
        if (!$obj) {
            session_destroy();
            die(error_page("Práctica 3", "Práctica 3", "Error consumiendo el servicio: " . $url));
        }

        //Si no hemos muerto antes, es que hemos decodificado el json y tenemos un objeto:

        //Si hemos obtenido "mensaje_error":
        if (isset($obj->mensaje_error)) {
            session_destroy();
            die(error_page("Práctica 3", "Práctica 3", $obj->mensaje_error));
        }

        //Si hemos obtenido "mensaje":
        if (isset($obj->mensaje)) {
            $error_usuario = true;
        } else {
            //Si hemos obtenido "usuario", es que nos hemos logueado:
            $_SESSION["usuario"] = $datos_envio["usuario"];
            $_SESSION["clave"] = $datos_envio["clave"];
            $_SESSION["ultimo_acceso"] = time();
            header("Location:index.php");
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .error {
            color: red;
        }

        .mensaje {
            color: blue;
        }
    </style>
    <title>Práctica 3</title>
</head>

<body>
    <h1>Práctica 3</h1>
    <form method="post" action="index.php">
        <p>
            <label for="usuario">Usuario: </label>
            <input type="text" id="usuario" name="usuario" value="<?php if (isset($_POST["usuario"]))
                echo $_POST["usuario"] ?>">
                <?php
            if (isset($_POST["btnLoguear"]) && $error_usuario) {
                if ($_POST["usuario"] == "") {
                    echo "<span class='error'>*Campo vacío*</span>";
                } else {
                    echo "<span class='error'>*Usuario o contraseña incorrectos*</span>";
                }
            }
            ?>
        </p>
        <p>
            <label for="clave">Contraseña: </label>
            <input type="password" id="clave" name="clave">
            <?php
            if (isset($_POST["btnLoguear"]) && $error_clave) {
                echo "<span class='error'>*Campo vacío*</span>";
            }
            ?>
        </p>
        <p>
            <button type="submit" name="btnLoguear">Iniciar sesión</button>
        </p>
    </form>
    <?php
    if (isset($_SESSION["seguridad"])) {
        echo "<p class='mensaje'>" . $_SESSION["seguridad"] . "</p>";
        unset($_SESSION["seguridad"]);
    }
    ?>
</body>

</html>
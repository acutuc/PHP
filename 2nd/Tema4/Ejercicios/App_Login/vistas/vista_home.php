<?php
if (isset($_POST["btnLogin"])) {
    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";

    $error_formulario = $error_usuario || $error_clave;

    //Si no hay error en el formulario, llamamos al servicio login() mandando los datos:
    if (!$error_formulario) {
        //LOS INDICES SE TIENEN QUE LLAMAR IGUAL QUE LOS DEL SERVICIO
        $datos["usuario"] = $_POST["usuario"];
        $datos["clave"] = md5($_POST["clave"]);

        //Llamamos al servicio:
        $url = DIR_SERV . "/login";
        $respuesta = consumir_servicios_REST($url, "POST", $datos);

        //Creamos el json de la respuesta obtenida:
        $obj = json_decode($respuesta);

        //Comprobamos, de la respuesta obtenida, los distintos tipos de errores (mensaje_error, mensaje):
        //Si no hemos obtenido un json:
        if (!$obj) {
            session_destroy();
            die(error_page("App Login", $respuesta));
        }

        //Si hemos obtenido mensaje_error:
        if (isset($obj->mensaje_error)) {
            session_destroy();
            die(error_page("App Login", $obj->mensaje_error));
        }

        //Si hemos obtenido mensaje, es que el usuario o la contraseña no coinciden:
        if (isset($obj->mensaje)) {
            $error_usuario = true;
        } else {
            //Si hemos llegado aqui, tenemos que loguearnos:
            $_SESSION["usuario"] = $datos["usuario"];
            $_SESSION["clave"] = $datos["clave"];
            $_SESSION["ultima_accion"] = time();
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App Login</title>
</head>

<body>
    <h1>App Login</h1>
    <form method="post" action="index.php">
        <p>
            <label for="usuario">Usuario: </label>
            <input type="text" name="usuario" id="usuario" value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"] ?>" />
            <?php
            if (isset($_POST["btnLogin"]) && $error_usuario) {
                if ($_POST["usuario"] == "") {
                    echo "<span class='error'>**Campo vacío**</span>";
                } else {
                    echo "<span class='error'>**Usuario o contraseña incorrectas**</span>";
                }
            }
            ?>
        </p>
        <p>
            <label for="clave">Constraseña: </label>
            <input type="password" name="clave" id="clave">
            <?php
            if (isset($_POST["btnLogin"]) && $_POST["clave"] == "") {
                echo "<span class='error'>**Campo vacío**</span>";
            }
            ?>
        </p>
        <p>
            <button name="btnLogin">Login</button>
        </p>
    </form>
    <?php
    if (isset($_SESSION["seguridad"])) {
        echo "<p class='mensaje'>" . $_SESSION["seguridad"] . "</p>";
        session_destroy();
    }
    ?>
</body>

</html>
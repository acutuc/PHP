<?php
if (isset($_POST["btnEntrar"])) {
    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";

    $error_form = $error_usuario || $error_clave;
    if (!$error_form) {
        $url = DIR_SERV . "/login";
        $datos["usuario"] = $_POST["usuario"];
        $datos["clave"] = md5($_POST["clave"]);
        $respuesta = consumir_servicios_REST($url, "POST", $datos);
        $obj = json_decode($respuesta);

        if (!$obj) {
            session_destroy();
            die(error_page("Gestión de Guardias", "<p>" . $url . "</p>"));
        }
        if (isset($obj->error)) {
            session_destroy();
            die(error_page("Gestión de Guardias", "<p>" . $obj->error . "</p>"));
        }
        if (isset($obj->mensaje)) {
            $error_usuario = true;
        } else {
            $_SESSION["usuario"] = $datos["usuario"];
            $_SESSION["clave"] = $datos["clave"];
            $_SESSION["ultima_accion"] = time();
            $_SESSION["api_session"] = $obj->api_session;

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
    <title>Gestión de Guardias</title>
</head>

<body>
    <h1>Gestión de Guardias</h1>
    <form method="post" action="index.php">
        <p>
            <label for="usuario">Usuario: </label>
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
    if (isset($_SESSION["mensaje"])) {
        echo "<span class='mensaje'>" . $_SESSION["mensaje"] . "</span>";
    }
    ?>
</body>

</html>
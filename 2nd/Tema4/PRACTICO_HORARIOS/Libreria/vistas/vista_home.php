<?php
if (isset($_POST["btnEntrar"])) {
    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";

    $error_formulario = $error_usuario || $error_clave;

    if (!$error_formulario) {
        $url = DIR_SERV . "/login";

        $datos["usuario"] = $_POST["usuario"];
        $datos["clave"] = md5($_POST["clave"]);

        $respuesta = consumir_servicios_REST($url, "GET", $datos);
        $obj = json_decode($respuesta);

        if (!$obj) {
            session_destroy();
            die(error_page("Horarios profesores", $url));
        }
        if (isset($obj->error)) {
            session_destroy();
            die(error_page("Horarios profesores", $obj->error));
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
    <title>Practico</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body>
    <h1>Horarios profesores</h1>
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
</body>

</html>
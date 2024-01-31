<?php
session_name("practico");
session_start();

require "src/funciones_ctes.php";

if (isset($_POST["btnEntrar"])) {
    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";

    $error_formulario = $error_usuario || $error_clave;
    if (!$error_formulario) {
        $datos[] = $_POST["usuario"];
        $datos[] = md5($_POST["clave"]);

        $url = DIR_SERV."/login";
        $respuesta = consumir_servicios_REST($url, "POST", $datos);
        $obj = json_decode($respuesta);

        if(isset($obj->error)){

        }
        if(isset($obj->mensaje)){
            $error_usuario = true;
        }else{
            echo "si";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRACTICO</title>
    <style>
        .error {
            color: red
        }
    </style>
</head>

<body>
    <h1>Formulario inicio de sesión</h1>
    <form method="post" action="index.php">
        <p>
            <label for="usuario">Usuario: </label><input type="text" name="usuario" id="usuario" value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"] ?>" />
            <?php
            if (isset($_POST["btnEntrar"]) && $error_usuario) {
                if ($_POST["usuario"] == "") {
                    echo "<span class='error'>**Campo vacío**</span>";
                } else {
                    echo "<span class='error'>**Usuario o contraseña no coinciden**</span>";
                }
            }
            ?>
        </p>
        <p>
            <label for="clave">Contraseña: </label><input type="password" name="clave" id="clave" />
            <?php
            if (isset($_POST["btnEntrar"]) && $error_clave) {
                echo "<span class='error'>**Campo vacío**</span>";
            }
            ?>
        </p>
        <p>
            <button name="btnEntrar">Iniciar sesión</button>
        </p>
    </form>
</body>

</html>
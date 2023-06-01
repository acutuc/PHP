<?php
session_name("examen22_23");
session_start();

require "src/funciones.php";

if (isset($_POST["btnEntrar"])) {
    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";

    $error_formulario = $error_usuario || $error_clave;

    if(!$error_formulario){
        $url = 
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de guardias</title>
</head>

<body>
    <h1>Gestión de guardias</h1>

    <div>
        <form action="index.php" method="post">
            <p>
                <label for="usuario">Usuario: </label><input type="text" name="usuario" id="usuario" value="<?php if (isset($_POST["usuario"]))
                    echo $_POST["usuario"] ?>" />
                    <?php
                if (isset($_POST["btnEntrar"]) && $error_usuario) {
                    if ($_POST["usuario"] == "") {
                        echo "<span class='error'>* Campo vacío *</span>";
                    } else {
                        echo "<span class='error'>* Usuario ya se encuentra registrado *</span>";
                    }
                }
                ?>
            </p>
            <p>
                <label for="clave">Contraseña: </label><input type="password" name="clave" id="clave" />
                <?php
                if (isset($_POST["btnEntrar"]) && $error_clave) {
                    echo "<span class='error'>* Campo vacío *</span>";
                }
                ?>
            </p>
            <p>
                <button type="submit" name="btnEntrar">Entrar</button>
            </p>
        </form>
    </div>
</body>

</html>
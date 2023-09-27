<?php
if (isset($_POST["btnLogin"])) {
    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";
    $error_form_login = $error_usuario || $error_clave;

    //Si no hay error en el formulario, conectamos con la BBDD
    if (!$error_form_login) {
        //Conexión:
        try {
            $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {
            die("Imposible realizar la conexión. Error nº: " . mysqli_connect_errno() . ". " . mysqli_connect_error());
        }

        //Consulta:
        try {
            $consulta = "SELECT * FROM usuarios WHERE usuario = " . $_POST["usuario"] . " AND clave = " . $_POST["clave"];
            $resultado = mysqli_query($conexion, $consulta);

            //Si hay usuarios en la BD:
            if (mysqli_num_rows($resultado) > 0) {
                mysqli_free_result($resultado);
                mysqli_close($conexion);
                $_SESSION["usuario"] = $_POST["usuario"];
                $_SESSION["clave"] = $_POST["clave"];
                header("Location:index.php");
                exit;
            } else {
                $error_usuario = true;
                mysqli_free_result($resultado);
                mysqli_close($conexion);
            }
        } catch (Exception $e) {
            $mensaje = "Imposible realizar la conexión. Error nº: " . mysqli_errno($conexion) . ". " . mysqli_error($conexion);
            mysqli_close($conexion);
            session_destroy();
            die($mensaje);
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
    <title>Primer Login</title>
</head>

<body>
    <h1>Primer Login</h1>
    <form action="" method="post">
        <p>
            <label for="usuario">Usuario: </label>
            <input type="text" name="usuario" id="usuario" value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"] ?>">
            <?php
            if (isset($_POST["btnLogin"]) && $error_usuario) {
                if ($_POST["usuario"] == "") {
                    echo "<span class='error'>* Campo vacío *</span>";
                } else {
                    echo "<span class='error'>* El usuario no se encuentra en la Base de Datos *</span>";
                }
            }
            ?>
        </p>
        <p>
            <label for="clave">Contraseña: </label>
            <input type="password" name="clave" id="clave">
            <?php
            if (isset($_POST["btnLogin"]) && $error_clave) {
                echo "<span class='error'>* Campo vacío *</span>";
            }
            ?>
        </p>
        <p>
            <button name="btnLogin">Entrar</button> &nbsp; <button name="btnRegistro">Registrar</button>
        </p>
    </form>

</body>

</html>
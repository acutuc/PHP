<?php
require "src/bd_config.php";

function salto_POST($action, $name){
    echo "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'><title></title></head>";

    echo "<body onload='document.getElementById(\"form_salto\").submit()'>";
    echo "<form id='form_salto' action= '".$action."' method='post'>";
    echo "<input type='hidden' name='".$name."' value='ok'>";
    echo "</form>";
    echo "</body>";
}

function repetido($conexion, $tabla, $columna, $valor)
{
    $consulta = "SELECT " . $columna . " FROM " . $tabla . " WHERE " . $columna . " = '" . $valor . "'";

    try {
        $resultado = mysqli_query($conexion, $consulta);

        $respuesta = mysqli_num_rows($resultado) > 0;

        mysqli_free_result($resultado);
    } catch (Exception $e) {
        $respuesta = "Imposible conectar. Error nº: " . mysqli_errno($conexion) . ". " . mysqli_error($conexion); 
    }

    return $respuesta;

}


function pag_error($titulo, $encabezado, $mensaje)
{
    return "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'><title>" . $titulo . "</title></head><body><h1>" . $encabezado . "</h1><p>" . $mensaje . "</p></body></html>";
}

if (isset($_POST["btnContinuar"])) {

    $error_nombre = $_POST["nombre"] == "";
    $error_usuario = $_POST["usuario"] == "";
    $error_contraseña = $_POST["contraseña"] == "";
    $error_email = $_POST["email"] == "" || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);

    $error_formulario = $error_nombre || $error_usuario || $error_contraseña || $error_email;

    if (!$error_formulario) {
        try {
            $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {
            die(pag_error("Práctica 1 CRUD", "Nuevo Usuario", "Imposible conectar. Error nº: " . mysqli_connect_errno() . ". " . mysqli_connect_error()));
        }

        $error_usuario = repetido($conexion, "usuarios", "usuario", $_POST["usuario"]);

        if(is_string($error_usuario)){
            mysqli_close($conexion);
            die(pag_error("Práctica 1 CRUD", "Nuevo Usuario", $error_usuario));
        }else{
            if (!$error_usuario) {
                $consulta = "INSERT INTO usuarios (nombre, usuario, clave, email) VALUES ('".$_POST["nombre"]."','".$_POST["usuario"]."', '".md5($_POST["contraseña"])."', '".$_POST["email"]."')";

                try {
                    mysqli_query($conexion, $consulta);
                    mysqli_close($conexion);
                    salto_POST("index.php", "usuario_nuevo");
                    exit();              
                } catch (Exception $e) {
                    $mensaje = "Imposible conectar. Error nº: " . mysqli_errno($conexion) . ". " . mysqli_error($conexion);
                    mysqli_close($conexion);
                    die(pag_error("Práctica 1 CRUD", "Nuevo Usuario", $mensaje));
                }
            }
        }

        
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Práctica 1 CRUD</title>
</head>

<body>
    <h1>Nuevo Usuario</h1>
    <form action="usuario_nuevo.php" method="post">
        <p>
            <label for="nombre">Nombre: </label><input type="text" name="nombre" id="nombre" value="<?php if (isset($_POST["nombre"])) echo $_POST["nombre"] ?>" maxlength="30">
            <?php
            if (isset($_POST["btnContinuar"]) && $error_nombre) {
                echo "<span class='error'>*Campo vacío*</span>";
            }
            ?>
        </p>
        <p>
            <label for="usuario">Usuario: </label><input type="text" name="usuario" id="usuario" value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"] ?>" maxlength="20">
            <?php
            if (isset($_POST["btnContinuar"]) && $error_usuario) {
                if ($_POST["usuario"] == "") {
                    echo "<span class='error'>*Campo vacío*</span>";
                }
                echo "<span class='error'>*Usuario repetido*</span>";
            }
            ?>
        </p>
        <p>
            <label for="contraseña">Contraseña: </label><input type="password" name="contraseña" id="contraseña" maxlength="20">
            <?php
            if (isset($_POST["btnContinuar"]) && $error_contraseña) {
                echo "<span class='error'>*Campo vacío*</span>";
            }
            ?>
        </p>
        <p>
            <label for="email">Email: </label><input type="text" name="email" id="email" value="<?php if (isset($_POST["email"])) echo $_POST["email"] ?>" maxlength="50">
            <?php
            if (isset($_POST["btnContinuar"]) && $error_email) {
                if ($_POST["email"] == "") {
                    echo "<span class='error'>*Campo vacío*</span>";
                } else {
                    echo "<span class='error'>*Email con errores sintácticos*</span>";
                }
            }
            ?>
        </p>
        <p>
            <!--El atributo formaction le cambia el action al botón-->
            <button type="submit" name="btnVolver" formaction="index.php">Volver</button>&nbsp;
            <button type="submit" name="btnContinuar">Continuar</button>
    </form>
    </p>
</body>

</html>
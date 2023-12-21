<?php
session_name("examen3_22_23");
session_start();
require "src/funciones_ctes.php";

if (isset($_POST["btnEntrar"])) {
    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";

    $error_form = $error_usuario || $error_clave;

    if (!$error_form) {
        try {
            $conexion = mysqli_connect(HOSTNAME_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {
            die(error_page("Página Inicio", "<p>No se ha podido realizar la conexión. Error: " . $e->getMessage() . "</p>"));
        }

        try {
            $consulta = "SELECT * FROM usuarios WHERE lector = '" . $_POST["usuario"] . "' AND clave = '" . md5($_POST["clave"]) . "'";
            $resultado = mysqli_query($conexion, $consulta);
        } catch (Exception $e) {
            mysqli_close($conexion);
            die(error_page("Página Incio", "<p>No se ha podido realizar la consulta. Error: " . $e->getMessage() . "</p>"));
        }

        if (mysqli_num_rows($resultado) > 0) {
            $_SESSION["usuario"] = $_POST["usuario"];
            $_SESSION["clave"] = md5($_POST["clave"]);
            $_SESSION["ultima_accion"] = time();
            header("Location:index.php");
            exit();
        }

        $error_usuario = true;
    }
}
?>
<?php
if (isset($_SESSION["usuario"])) {
    require "src/seguridad.php";
    if($datos_usu_log["tipo"] == "admin"){
        header("Location:admin/gest_libros.php");
        exit();
    }
    require "vistas/vista_normal.php";
} else {
    require "vistas/vista_login.php";
}
?>
<?php
define("MINUTOS", 5);
//Conectamos a la BD con $_SESSION para hacer el baneo:
try {
    $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
} catch (PDOException $e) {
    die(error_page("Login PDO", "Login con PDO", "<p>Imposible conectar. Error: " . $e->getMessage() . "</p></body></html>"));
}

//Consulta:
try {
    $consulta = "SELECT * FROM usuarios WHERE usuario = ? AND clave = ?";

    $sentencia = $conexion->prepare($consulta);

    $sentencia->execute([$_SESSION["usuario"], $_SESSION["clave"]]);

    if ($sentencia->rowCount() > 0) {
        $datos_usuario_log = $sentencia->fetch(PDO::FETCH_ASSOC);
        $sentencia = null;
    } else {
        $sentencia = null;
        //Si no hay tuplas (has sido eliminado de la BD):
        //Eliminamos todas las variables de session creadas hasta ahora($_SESSION["usuario"], ["clave"], ["ultimo_acceso"])
        session_unset();

        $_SESSION["seguridad"] = "El usuario ya no se encuentra registrado en la BD";
        //y saltamos a index:
        header("Location:index.php");//Recarga
        exit();
    }
} catch (PDOException $e) {
    $sentencia = null; //Libera sentencia
    $conexion = null; //Cierra conexión
    die(error_page("Login PDO", "Login con PDO", "<p>Imposible conectar. Error: " . $e->getMessage() . "</p></body></html>"));
}

//Controlamos el tiempo de sesión a 5 minutos:
if (time() - $_SESSION["ultimo_acceso"] > 60 * MINUTOS) {
    //Eliminamos todas las variables de session creadas hasta ahora($_SESSION["usuario"], ["clave"], ["ultimo_acceso"])
    session_unset();

    $_SESSION["seguridad"] = "Su tiempo de sesión ha caducado";//Sesión expirada
    //y saltamos a index:
    header("Location:index.php");//Recarga
    exit();
}
//Refrescamos el tiempo de acceso:
$_SESSION["ultimo_acceso"] = time(); //Actualiza el último acceso
?>
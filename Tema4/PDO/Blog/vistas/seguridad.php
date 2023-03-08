<?php
//Conectamos a la BD:
try {
    $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
} catch (PDOException $e) {
    die(error_page("Blog Personal", "Blog Personal", "<p>Imposible conectar. Error: " . $e->getMessage() . "</p></body></html>"));
}

//Hacemos la consulta:
try {
    $consulta = "SELECT * FROM usuarios WHERE usuario = ? AND clave = ?";

    //Preparamos la sentencia:
    $sentencia = $conexion->prepare($consulta);

    //Almacenamos en $datos.
    $datos[] = $_SESSION["usuario"];
    $datos[] = $_SESSION["clave"];

    //Ejecutamos la sentencia:
    $sentencia->execute($datos);

    //Si existe el usuario:
    if ($sentencia->rowCount() > 0) {
        //Guardamos los datos del usuario logeado:
        $datos_usuario_log = $sentencia->fetch(PDO::FETCH_ASSOC);

        //Limpiamos la sentencia.
        $sentencia = null;
    } else {
        $sentencia = null;
        session_unset();

        $_SESSION["seguridad"] = "El usuario ya no se encuentra registrado en la BD.";
        header("Location:index.php");
        exit();
    }
} catch (PDOException $e) {
    $sentencia = null; //Libera sentencia
    $conexion = null; //Cierra conexión
    die(error_page("Blog Personal", "Blog Personal", "<p>Imposible conectar. Error: " . $e->getMessage() . "</p></body></html>"));
}

//Controlamos el tiempo de sesión a 5 minutos.
if (time() - $_SESSION["ultimo_acceso"] > 60 * 5) {
    //Eliminamos todas las variables $_SESSION.
    session_unset();

    $_SESSION["seguridad"] = "Su tiempo ha caducado"; //Sesión expirada.
    header("Location:index.php");
    exit();
}
//Refrescamos el tiempo de acceso:
$_SESSION["ultimo_acceso"] = time();
?>
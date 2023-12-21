<?php
if (!isset($conexion)) {
    try {
        $conexion = mysqli_connect(HOSTNAME_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        die("<p>No se ha podido realizar la conexión. Error: " . $e->getMessage() . "</p>");
    }
}
    try{
        $consulta = "SELECT * FROM usuarios WHERE lector = '".$_SESSION["usuario"]."' AND clave = '".$_SESSION["clave"]."'";
        $resultado = mysqli_query($conexion, $consulta);
    }catch(Exception $e){
        mysqli_close($conexion);
        die("<p>No se ha podido realizar la consulta. Error: ".$e->getMessage()."</p>");
    }

    //Control de baneo:
    if(mysqli_num_rows($resultado) == 0){
        mysqli_close($conexion);
        mysqli_free_result($resultado);
        session_unset();
        $_SESSION["seguridad"] = "Usted ha sido baneado.";
        header("Location:index.php");
        exit();
    }

    $datos_usu_log = mysqli_fetch_assoc($resultado);
    $_SESSION["lector"] = $datos_usu_log["lector"];
    $_SESSION["tipo"] = $datos_usu_log["tipo"];
    mysqli_free_result($resultado);

    //Control de tiempo:
    if(time() - $_SESSION["ultima_accion"] > MINUTOS * 2){
        mysqli_close($conexion);
        mysqli_free_result($resultado);
        session_unset();
        $_SESSION["seguridad"] = "El tiempo de sesión ha caducado.";
        header("Location:index.php");
        exit();
    }

    $_SESSION["ultima_accion"] = time();

?>

<?php

try {
    $consulta = "SELECT * FROm usuarios WHERE lector = ? AND clave = ?";

    $sentencia = $conexion->prepare($consulta);

    $datos[] = $_SESSION["usuario"];
    $datos[] = $_SESSION["clave"];

    $sentencia->execute($datos);
} catch (Exception $e) {
    session_destroy();
    $conexion = null;
    die(error_page("Examen3 Curso 23-24", "<h1>Librería</h1><p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p>"));
}

if ($sentencia->rowCount() <= 0) {
    $sentencia = null;
    $conexion = null;
    session_unset();
    $_SESSION["seguridad"] = "Usted ya no se encuentra registrado en la BD";
    header("Location:" . $salto);
    exit;
}

$datos_usuario_logueado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
$sentencia = null;

// Ahora control de inactividad

if (time() - $_SESSION["ultima_accion"] > MINUTOS_INACT * 60) {
    $conexion = null;
    session_unset();
    $_SESSION["seguridad"] = "Su tiempo de sesión ha caducado";
    header("Location:" . $salto);
    exit;
}

$_SESSION["ultima_accion"] = time();

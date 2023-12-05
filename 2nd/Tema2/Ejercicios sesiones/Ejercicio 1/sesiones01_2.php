<?php
session_name("Ejercicio1");
session_start();
if (isset($_POST["btnSiguiente"])) {

    if ($_POST["nombre"] == "") {
        $_SESSION["error"] = "* Campo vacío *";
        header("Location:sesiones01_1.php");
        exit;

    } else {
        $_SESSION["nombre"] = $_POST["nombre"];
    }

} else if (isset($_POST["btnBorrar"])) {
    session_destroy();
    header("Location:sesiones01_1.php");
    exit;
} else {
    header("Location:sesiones01_1.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ejercicio 1</title>
</head>

<body>
    <h2>FORMULARIO NOMBRE 1 (RESULTADO)</h2>
    <p>Su nombre es: <strong><?php echo $_SESSION["nombre"]; ?></strong></p>
    <p><a href="sesiones01_1.php">Volver</a></p>
</body>

</html>
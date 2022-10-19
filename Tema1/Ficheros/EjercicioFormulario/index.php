<?php
//Función que comprueba la letra del DNI.
function LetraNIF($dni)
{
    return substr("TRWAGMYFPDXBNJZSQVHLCKEO", $dni % 23, 1);
}

function bien_escrito($texto)
{
    $dni = strtoupper($texto);
    return strlen($dni) == 9 && is_numeric(substr($dni, 0, 8)) && substr($dni, 8, 1) >= "A" && substr($dni, 8, 1) <= "Z";
}

function dni_valido($texto)
{
    $dni = strtoupper($texto);
    LetraNIF(substr($dni, 0, 8)) == substr($dni, 8, 1);
}

if (isset($_POST["btnReset"])) {
    header("Location: index.php");
    exit;
}

//COMPROBAMOS ERRORES:
if (isset($_POST["btnGuardar"])) {
    $error_nombre = $_POST["nombre"] == "";
    $error_usuario = $_POST["usuario"] == "";
    $error_contrasenia = $_POST["contrasenia"] == "";
    $error_dni = $_POST["dni"] == "" || !bien_escrito($_POST["dni"]) || !dni_valido($_POST["dni"]);
    $error_sexo = !isset($_POST["sexo"]);

    $error_formulario = $error_nombre || $error_usuario || $error_contrasenia || $error_dni || $error_sexo;
}

if (isset($_POST["btnGuardar"]) && !$error_formulario) {
    require "vistas/vista_respuesta.php";
} else {
    require "vistas/vista_formulario.php";
}

?>
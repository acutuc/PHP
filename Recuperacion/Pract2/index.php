<?php
//Funciones:
function bien_escrito($texto)
{
    $dni = strtoupper($texto);
    return strlen($dni) == 9 && is_numeric(substr($dni, 0, 8)) && substr($dni, 8, 1) >= "A" && substr($dni, 8, 1) <= "Z";
}

//Si pulsamos Entrar en el login inicial:
if (isset($_POST["btnEntrar"])) {
    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";

    $error_formulario = $error_usuario || $error_clave;

    //Si no hay error en formulario, iniciamos sesión:
    if (!$error_formulario) {

    }
}

//Si pulsamos Registrarse en el login inicial o Guardar Cambios en el formulario de registro:
if (isset($_POST["btnRegistrarse"]) || isset($_POST["btnGuardar"]) || isset($_POST["btnBorrar"])) {
    require "vistas/vista_registro.php";
} else {
    require "vistas/vista_login.php";
}
?>
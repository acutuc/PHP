<?php
session_name("examen_final");
session_start();

require "src/funciones_ctes.php";

//No podemos entrar a la página si no estamos logueados
if (isset($_SESSION["usuario"])) {
    if (isset($_POST["bntSalir"])) {
        consumir_servicios_REST(DIR_SERV . "/salir", "POST", $_SESSION["api_session"]);
        session_destroy();
        header("Location:index.php");
        exit();
    }
    require "src/seguridad.php";

    require "vistas/vista_principal.php";
} else {
    header("Location:index.php");
    exit();
}


?>


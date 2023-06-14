<?php
require "src/funciones_ctes.php";
session_name("examen_final");
session_start();

if (isset($_POST["btnSalir"])) {
    $url = "http://localhost/Proyectos/Examen_Servicios_Web/servicios_rest";
    consumir_servicios_REST($url . "/salir", "POST", $_SESSION["api_session"]);
    session_destroy();
    header("Location:index.php");
    exit();
}

if (isset($_SESSION["usuario"])) {
    require "src/seguridad.php";

    //Salto a principal.php
    header("Location:principal.php");
    exit();
} else {
    require "vistas/vista_login.php";
}

?>
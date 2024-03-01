<?php
session_name("sesiones_aplicacion");
session_start();
require "src/funciones_ctes.php";

if (isset($_POST["btnSalir"])) {
    consumir_servicios_REST(DIR_SERV . "/salir", "GET", [$_SESSION["api_session"]]);
    session_destroy();
    header("Location:index.php");
    exit();
}

if (isset($_SESSION["usuario"])) {
    //Seguridad:
    require "src/seguridad.php";

    if ($datos_usu_log->tipo == "admin") {
        header("Location:admin/gest_horarios.php");
        exit();
    } else {
        require "vistas/vista_normal.php";
    }
} else {
    require "vistas/vista_home.php";
}
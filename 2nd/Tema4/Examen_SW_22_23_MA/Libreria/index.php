<?php
session_name("examen_22_23_aplicacion");
session_start();
require "src/funciones_ctes.php";

if (isset($_POST["btnSalir"])) {
    $url = DIR_SERV . "/salir";
    $datos["api_session"] = $_SESSION["api_session"];
    $respuesta = consumir_servicios_REST($url, "POST", $datos);
    session_destroy();
    header("Location:index.php");
    exit();
}

if (isset($_SESSION["usuario"])) {
    $salto = "index.php";
    //Estoy logueado.
    //SEGURIDAD
    require "src/seguridad.php";

    //Preguntamos si somos admin o normal:
    if ($datos_usu_log->tipo == "admin") {
        header("Location:admin/gest_libros.php");
        exit();
    } else {
        require "vistas/vista_normal.php";
    }
} else {
    require "vistas/vista_home.php";
}

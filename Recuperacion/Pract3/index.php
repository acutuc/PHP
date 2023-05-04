<?php
session_name("Practica_3_SW_REC");
session_start();

require "src/funciones.php";

if (isset($_SESSION["usuario"])) {

    if (isset($_POST["btnSalir"])) {
        session_destroy();
        header("Location:index.php");
        exit;
    }

    //Controlo baneo
    require "src/seguridad.php";

    //Muestro vista oportuna    
    if ($datos_usu_log->tipo == "admin") {
        require "vistas/vista_admin.php";
    } else {
        require "vistas/vista_normal.php";
    }

} else {
    require "vistas/vista_home.php";
}
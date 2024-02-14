<?php
session_name("Examen_SW_23_24");
session_start();
require "src/funciones_ctes.php";

if (isset($_POST["btnSalir"])) {
    consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos);
    session_destroy();
    header("Location:index.php");
    exit();
}


if (isset($_SESSION["usuario"])) {
    require "src/seguridad.php";

    require "vistas/vista_examen.php";
} else {
    require "vistas/vista_login.php";
}

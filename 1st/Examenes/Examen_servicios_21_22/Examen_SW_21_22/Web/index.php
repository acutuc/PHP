<?php
session_name("examen_sw_22_23");
session_start();
require "src/ctes_funciones.php";

if(isset($_POST["btnCerrarSesion"])){
    $url = DIR_SERV."/salir";
    consumir_servicios_REST($url, "POST", $_SESSION["api_session"]);
    session_destroy();
    header("Location:index.php");
    exit();
}

if (isset($_SESSION["usuario"])) {

    require "src/seguridad.php";

    if ($datos_usu_log->tipo == "admin") {
        require "vistas/vista_principal.php";
    } else {
        require "vistas/vista_normal.php";
    }

} else {
    require "vistas/vista_login.php";
}

?>
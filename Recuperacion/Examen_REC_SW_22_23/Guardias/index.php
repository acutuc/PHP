<?php
session_name("examen22_23");
session_start();

require "src/funciones.php";

if(isset($_POST["btnSalir"])){
    consumir_servicios_REST(DIR_SERV."/salir", "POST", $_SESSION["api_session"]);
    session_destroy();
    header("Location: index.php");
    exit();
}

if(isset($_SESSION["usuario"])){
    //Estamos logueados
    require "src/seguridad.php";

    require "vistas/vista_logueado.php";
}else{
    //No estamos logueados
    require "vistas/vista_login.php";
}

?>
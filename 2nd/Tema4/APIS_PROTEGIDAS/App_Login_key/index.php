<?php
session_name("App_Login");
session_start();

require "src/funciones_ctes.php";

if(isset($_POST["btnSalir"])){
    //Si pulsamos en salir, destruimos la sesion de la api tambien:
    $datos["api_key"] = $_SESSION["api_key"];
    $url = DIR_SERV."/salir";
    $respuesta = consumir_servicios_REST($url, "POST", $datos);

    session_destroy();
    header("Location:index.php");
    exit();
}

if (isset($_SESSION["usuario"])) {
    //Nos hemos logueado, pasamos por seguridad:
    require "src/seguridad.php";

    //Comprobamos el tipo de usuario.
    //Si es normal:
    if ($datos_usu_log->tipo == "normal") {
        require "vistas/vista_normal.php";
    } else {
        //Si es admin:
        require "vistas/vista_admin.php";
    }
} else {
    //Formulario de inicio de sesión y control de errores:
    require "vistas/vista_home.php";
    
}
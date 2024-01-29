<?php
session_name("App_Login");
session_start();

require "src/funciones_ctes.php";

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
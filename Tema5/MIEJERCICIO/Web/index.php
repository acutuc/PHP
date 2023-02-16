<?php
session_name("examen_sw_22_23");
session_start();

require "src/ctes_funciones.php";


if (isset($_SESSION["usuario"])) {
    //El usuario se ha logueado al menos una vez correctamente
    //Primero compruebo si se ha baneado
    require "src/seguridad.php";
    
    if($datos_usuario_log->tipo == "admin"){
        require "vistas/vista_admin.php";
    }else{
        require "vistas/vista_login.php";
    }
} else {
    //El usuario no se ha logueado aún
    require "vistas/vista_login.php";
}
<?php
session_name("Practica_3_SW_REC");
session_start();

if(isset($_POST["btnSalir"])){
    session_destroy();
    header("Location:index.php");
    exit();
}

require "src/funciones.php";
if (isset($_SESSION["usuario"])) {

    //Controlamos baneo:
    require "src/seguridad.php";

    if ($datos_usuario_log->tipo == "admin") {
        require "vistas/vista_admin.php";
    } else {
        require "vistas/vista_normal.php";
    }
    
} else {

    require "vistas/vista_login.php";

}
?>
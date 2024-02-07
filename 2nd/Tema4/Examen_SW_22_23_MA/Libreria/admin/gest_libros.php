<?php
session_name("examen_22_23_aplicacion");
session_start();
require "../src/funciones_ctes.php";

//Controlamos que si alguien no está logueado, que no entre por aquí:
if (isset($_SESSION["usuario"])) {
    $salto = "../index.php";

    require "../src/seguridad.php";

    if ($datos_usu_log->tipo == "admin") {
        require "../vistas/vista_admin.php";
    } else {
        header("Location:".$salto);
        exit();
    }
    
} else {
    header("Location:../index.php");
    exit();
}

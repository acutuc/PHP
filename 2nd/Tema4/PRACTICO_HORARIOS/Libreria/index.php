<?php
session_name("nombre_aplicacion");
session_start();

require "src/funciones_ctes.php";

if(isset($_POST["btnSalir"])){
    consumir_servicios_REST(DIR_SERV."/salir", "GET");
    session_destroy();
    header("Location:index.php");
    exit();
}

if(isset($_SESSION["usuario"])){

    if($_SESSION["tipo"] == "admin"){

    }else{
        
    }
}else{
    require "vistas/vista_home.php";
}


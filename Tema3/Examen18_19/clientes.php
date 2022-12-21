<?php
require "src/bd_config.php";
require "src/funciones.php";

session_name("Examen_18_19");
session_start();

if(isset($_SESSION["usuario"]) && isset($_SESSION["clave"]) && isset($_SESSION["ultimo_acceso"])){//Sólo entramos si existen los tres $_SESSION
    require "src/seguridad.php";

    if($datos_usuario_log["tipo"] == "normal"){
        require "vistas/vista_normal.php";
    }else{
        require "vistas/vista_normal.php";
    }

    mysqli_close($conexion);
    
}else{
    header("Location:index.php");
    exit;
}
?>
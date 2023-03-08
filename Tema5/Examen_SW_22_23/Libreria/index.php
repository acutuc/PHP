<?php
session_name("Exam_sw_22_23");
session_start();

require "src/ctes_funciones.php";

//
//





if(isset($_SESSION["lector"])){
    require "src/seguridad.php";

    if($datos_usuario_log->tipo == "admin"){
        header("Location:admin/index.php");
        exit();
    }else{
        require "vistas/vista_normal.php";
    }

}else{
    require "vistas/vista_login.php";
}
?>
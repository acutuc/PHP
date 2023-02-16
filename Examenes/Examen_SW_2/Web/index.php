<?php
    require "src/ctes_funciones.php";

    session_name("examen_horarios");
    session_start();

    if(isset($_POST["btnCerrarSesion"])){

        session_destroy();
        header("Location:index.php");
        exit;
    }

    if(isset($_SESSION["usuario"]) && isset($_SESSION["clave"]) && isset($_SESSION["ultimo_acceso"])){

        require "src/seguridad.php";

        if($datos_usuario_logueado->tipo == "normal"){

            require "vistas/vista_normal.php";
        }else{

            require "vistas/vista_principal.php";
        }
    }else{

        require "vistas/vista_login.php";
    }
?>
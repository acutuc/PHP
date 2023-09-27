<?php
session_name("examen_final_22_23");
session_start();
require "src/ctes_funciones.php";

if(isset($_POST["btnSalir"])){
    consumir_servicios_REST(DIR_SERV."/salir", "POST", $_SESSION["api_session"]);
    session_destroy();
    header("Location:index.php");
    exit();
}

if(isset($_SESSION["usuario"]) && isset($_SESSION["clave"]) && isset($_SESSION["ultimo_acceso"])&& isset($_SESSION["api_session"]))
{


    //El usuario se ha logueado al menos una vez correctamente
    //Primero compruebo si se ha baneado
    require "src/seguridad.php";

    if($datos_usuario_log->tipo=="admin")
        require "vistas/vista_admin.php";
    else
        require "vistas/vista_normal.php";


}
else
{
    //El usuario no se ha logueado aún
    require "vistas/vista_login.php";
}

<?php
session_name("Practica_Rec_2");
session_start();

require "src/bd_config.php";

require "src/funciones.php";

//Si hemos pulsado "Salir" como admin o normal, destruimos las sessiones:
if(isset($_POST["btnSalir"])){
    session_destroy();
    header("Location:index.php");
    exit();
}

//Si pulsamos Registrarse en el login inicial o Guardar Cambios en el formulario de registro:
if (isset($_POST["btnRegistrarse"]) || isset($_POST["btnGuardar"]) || isset($_POST["btnBorrar"])) {
    require "vistas/vista_registro.php";
    
    //Si existe $_SESSION:
} else if (isset($_SESSION["usuario"]) && isset($_SESSION["clave"]) && isset($_SESSION["ultimo_acceso"])) {
    //Hacemos seguridad:
    require "src/seguridad.php";

    if($datos_usuario_log["tipo"] == "admin"){
        //Si somos admin:
        require "vistas/vista_admin.php";
    }else{
        //Si somos normal:
        require "vistas/vista_normal.php";
    }
} else {
    require "vistas/vista_login.php";
}
?>
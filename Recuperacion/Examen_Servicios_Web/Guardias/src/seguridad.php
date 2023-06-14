<?php
    $url = DIR_SERV."/logueado";

    $respuesta = consumir_servicios_REST($url, "POST", $_SESSION["api_session"]);

    $obj = json_decode($respuesta);

    if(!$obj){
        consumir_servicios_REST(DIR_SERV."/salir", "POST", $_SESSION["api_session"]);
        session_destroy();
        die(error_page("Gestión de Guardias", "Gestión de Guardias", $url.$respuesta));
    }

    if(isset($obj->error)){
        consumir_servicios_REST(DIR_SERV."/salir", "POST", $_SESSION["api_session"]);
        session_destroy();
        die(error_page("Gestión de Guardias", "Gestión de Guardias", $obj->error));
    }

    $datos_usu_log = $obj->usuario;

    if(time() - $_SESSION["ultima_accion"] > MINUTOS * 60){
        consumir_servicios_REST(DIR_SERV."/salir", "POST", $_SESSION["api_session"]);
        session_unset();
        $_SESSION["seguridad"] = "Su tiempo de sesión ha caducado";
        header("Location:index.php");
        exit();
    }

    //Refresco
    $_SESSION["ultima_accion"] = time();
?>
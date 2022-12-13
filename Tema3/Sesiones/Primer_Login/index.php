<?php
require "src/bd_config.php";
session_name("primer_login");
session_start();

//Si hay usuario, entra en la página web
if(isset($_SESSION["usuario"]) && isset($_SESSION["clave"])){
    require "vistas/vista_principal.php";

}

if (isset($_POST["btnRegistro"])) {
    echo "vista registro";

} else {
    require "vistas/vista_login.php";

}
?>
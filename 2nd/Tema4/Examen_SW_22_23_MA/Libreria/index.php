<?php
session_name("examen_22_23_aplicacion");
session_start();
require "src/funciones_ctes.php";

if(isset($_POST["btnSalir"])){

}

if(isset($_SESSION["usuario"])){
    //Estoy logueado

}else{
    require "vistas/vista_home.php";
}




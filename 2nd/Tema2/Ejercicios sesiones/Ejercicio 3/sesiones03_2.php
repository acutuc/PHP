<?php
session_name("Ejercicio3");
session_start();

if(isset($_POST["btnContador"])){
    if($_POST["btnContador"] == "menos"){
        $_SESSION["numero"] -= 1;
    }elseif($_POST["btnContador"] == "mas"){
        $_SESSION["numero"] += 1;
    }else{
        session_destroy();
    }
}

header("Location:sesiones03_1.php");
exit();
?>
<?php
session_name("erjercicio2");
session_start();
if (isset($_POST["btnSiguiente"])) {

    if ($_POST["nombre"] == "") {

        $_SESSION["error"] = "* Campo vacío *";
        header("Location:ejercicio2.php");
        exit;
    } else {
        $_SESSION["nombre"] = $_POST["nombre"];
        header("Location:ejercicio2.php");
        exit;
    }
} else if (isset($_POST["btnBorrar"])) {
    session_destroy();
    header("Location:ejercicio2.php");
    exit;
} else {
    header("Location:ejercicio2.php");
    exit;
}

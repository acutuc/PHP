<?php
session_name("ejercicio3");
session_start();
if (isset($_POST["btnRestar"])) {
    $_SESSION["contador"]--;
    header("Location:ejercicio3.php");
    exit;
} else if (isset($_POST["btnSumar"])) {
    $_SESSION["contador"]++;
    header("Location:ejercicio3.php");
    exit;
} else if (isset($_POST["btnReset"])) {
    session_destroy();
    header("Location:ejercicio3.php");
    exit;
} else {
    header("Location:ejercicio3.php");
    exit;
}
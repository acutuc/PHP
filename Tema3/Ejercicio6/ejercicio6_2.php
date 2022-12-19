<?php
session_name("ejercicio6");
session_start();
if (isset($_POST["btnMover"])) {
    if ($_POST["btnMover"] == "azul") {
        $_SESSION["pos_azul"] += 10;
    } else if ($_POST["btnMover"] == "naranja") {
        $_SESSION["pos_naranja"] += 10;
    } else {
        session_destroy();
    }
}
header("Location:ejercicio6.php");
exit;

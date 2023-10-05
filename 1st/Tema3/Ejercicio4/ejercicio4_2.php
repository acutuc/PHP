<?php
session_name("ejercicio4");
session_start();
if (isset($_POST["btnMover"])) {
    if ($_POST["btnMover"] == "izquierda") {

        if ($_SESSION["pos_x"] == -300) {
            $_SESSION["pos_x"] = 300;
        } else {
            $_SESSION["pos_x"] -= 20;
        }
    } else {

        if ($_SESSION["pos_x"] == 300) {
            $_SESSION["pos_x"] = -300;
        } else {
            $_SESSION["pos_x"] += 20;
        }
    }
} else if (isset($_POST["btnReset"])) {
    session_destroy();
}
header("Location:ejercicio4.php");
exit;

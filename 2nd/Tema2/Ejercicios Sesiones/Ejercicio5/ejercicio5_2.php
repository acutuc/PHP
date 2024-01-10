<?php
session_name("ejercicio5");
session_start();
if (isset($_POST["btnMover"])) {
    if ($_POST["btnMover"] == "izquierda") {

        if ($_SESSION["pos_x"] == -200) {
            $_SESSION["pos_x"] = 200;
        } else {
            $_SESSION["pos_x"] -= 20;
        }
    } else if ($_POST["btnMover"] == "derecha") {

        if ($_SESSION["pos_x"] == 200) {
            $_SESSION["pos_x"] = -200;
        } else {
            $_SESSION["pos_x"] += 20;
        }
    } else if ($_POST["btnMover"] == "arriba") {

        if ($_SESSION["pos_y"] == -200) {
            $_SESSION["pos_y"] = 200;
        } else {
            $_SESSION["pos_y"] -= 20;
        }
    } else {

        if ($_SESSION["pos_y"] == 200) {
            $_SESSION["pos_y"] = -200;
        } else {
            $_SESSION["pos_y"] += 20;
        }
    }
} else if (isset($_POST["btnReset"])) {
    session_destroy();
}
header("Location:ejercicio5.php");
exit;

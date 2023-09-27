<?php
session_name("ejercicio7");
session_start();
if (isset($_POST["btnMover"])) {
    if ($_POST["btnMover"] == "restar") {
        $_SESSION["numero"] -= 1;
    } else if ($_POST["btnMover"] == "sumar") {
        $_SESSION["numero"] += 1;
    } else {
        $_SESSION["btnMover"] = "tirar";
    }
} else {
    session_destroy();
}
header("Location:ejercicio7.php");
exit;
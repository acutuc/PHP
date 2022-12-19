<?php
session_name("ejercicio8");
session_start();
if (isset($_POST["btnMover"])) {
    if ($_POST["btnMover"] == "a") {
        $_SESSION["numero_a"] = rand(1, 6);
        $_SESSION["pos_a"] += $_SESSION["numero_a"];
        
    } else if ($_POST["btnMover"] == "b") {
        $_SESSION["numero_b"] = rand(1, 6);
        $_SESSION["pos_b"] += $_SESSION["numero_b"];
    } else {
        session_destroy();
    }
}
header("Location:ejercicio8.php");
exit;
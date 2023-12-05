<?php
session_name("Ejercicio3");
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir y bajar número</title>
</head>
<body>
    <h1>SUBIR Y BAJAR NÚMERO</h1>
    <form method="post" action="sesiones03_2.php">
        <button name="btnContador" value="menos">-</button>
        <?php
        if(isset($_SESSION["numero"])){
            echo $_SESSION["numero"];
        }else{
            echo "0";
        }
        ?>
        <button name="btnContador" value="mas">+</button>
        <p>
            <button name="btnContador" value="cero">Poner a cero</button>
        </p>
    </form>
</body>
</html>
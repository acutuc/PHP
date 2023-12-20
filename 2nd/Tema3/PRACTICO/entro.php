<?php
    session_name("practico");
    session_start();
    if(isset($_POST["btnSalir"])){
        session_destroy();
        header("Location:index.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entro</title>
</head>
<body>
    <h1>HEMOS ENTRADO COMO <?php echo $_SESSION["usuario"] ?></h1>
    <?php  
        echo "<p>".$_SESSION["usuario"]."</p>";
        echo "<p>".$_SESSION["clave"]."</p>";
        echo "<p>".$_SESSION["DNI"]."</p>";
        echo "<p>".$_SESSION["telefono"]."</p>";
        echo "<p>".$_SESSION["email"]."</p>";
    ?>
    <form action="entro.php" method="post">
        <button name="btnSalir">Salir</button>
    </form>
</body>
</html>
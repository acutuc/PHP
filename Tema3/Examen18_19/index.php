<?php
    session_name("Examen_18_19");
    session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen 18/19</title>
</head>
<body>
    <h1>Video Club</h1>
    <form method="post" action="index.php">
        <p>
            <label for="usuario">Usuario: </label>
            <input type="text" name="usuario" id="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"] ?>">
        </p>
        <p>
            <label for="clave">Contraseña: </label>
            <input type="password" name="clave" id="clave">
        </p>
        <p>
            <button type="submit" name="btnLogin">Entrar</button>
            <button type="submit" formaction="registro_usuario.php" name="btnRegistro">Registrar</button>
        </p>
    </form>
    <?php
        if(isset($_SESSION["baneo"])){
            echo "<p class='mensaje'>".$_SESSION["baneo"]."</p>";
            session_unset($_SESSION["baneo"]);
        }
        if(isset($_SESSION["tiempo"])){
            echo "<p class='mensaje'>".$_SESSION["tiempo"]."</p>";
            session_unset($_SESSION["tiempo"]);
        }
    ?>
</body>
</html>
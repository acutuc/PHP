<?php
if(isset($_POST["btnContinuarRegistro"]))
{
    $error_nombre=$_POST["nombre"]=="";
    $error_usuario=$_POST["usuario"]=="";
    if(!$error_usuario)
    {
        try
        {
            $conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
            mysqli_set_charset($conexion,"utf8");

        }
        catch(Exception $e)
        {
            $mensaje="Imposible conectar con la BD. Error Nº ".mysqli_connect_errno()." : ".mysqli_connect_error();
            session_destroy();
            die(error_page("Primer Login","Primer Login",$mensaje));
        }
        $error_usuario=repetido($conexion,"usuarios","usuario",$_POST["usuario"]);

        if(is_string($error_usuario))
        {
            mysqli_close($conexion);
            session_destroy();
            die(error_page("Primer Login","Primer Login",$error_usuario));
        }
    }
    $error_clave=$_POST["clave"]=="";
    $error_email=$_POST["email"]==""|| !filter_var($_POST["email"],FILTER_VALIDATE_EMAIL);
    if(!$error_email)
    {
        if(!isset($conexion))
        {
            try
            {
                $conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
                mysqli_set_charset($conexion,"utf8");

            }
            catch(Exception $e)
            {
                $mensaje="Imposible conectar con la BD. Error Nº ".mysqli_connect_errno()." : ".mysqli_connect_error();
                session_destroy();
                die(error_page("Primer Login","Primer Login",$mensaje));
            }
        }

        $error_email=repetido($conexion,"usuarios","email",$_POST["email"]);

        if(is_string($error_email))
        {
            mysqli_close($conexion);
            session_destroy();
            die(error_page("Primer Login","Primer Login",$error_usuario));
        }
    }

    $error_form_registro=$error_nombre||$error_usuario||$error_clave||$error_email;
    if(!$error_form_registro)
    {
        try
        {
            $consulta="insert into usuarios(nombre,usuario,clave,email) values('".$_POST["nombre"]."','".$_POST["usuario"]."','".md5($_POST["clave"])."','".$_POST["email"]."')";
            mysqli_query($conexion,$consulta);
            mysqli_close($conexion);

            $_SESSION["usuario"]=$_POST["usuario"];
            $_SESSION["clave"]=md5($_POST["clave"]);
            $_SESSION["ultimo_acceso"]=time();
            header("Location:index.php");
            exit;
            
            
        }
        catch(Exception $e)
        {
            $mensaje="Imposible realizar la consulta. Error Nº ".mysqli_errno($conexion)." : ".mysqli_error($conexion);
            mysqli_close($conexion);
            session_destroy();
            die(error_page("Primer Login","Primer Login",$mensaje));
        }
    }

    if(isset($conexion))
        mysqli_close($conexion);
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primer Login</title>
</head>
<body>
    <h1>Primer Login</h1>
    <form action="index.php" method="post">
        
        <p>
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" value="<?php if(isset($_POST["nombre"])) echo $_POST["nombre"];?>" maxlength="30"/>
            <?php
            if(isset($_POST["nombre"]) && $error_nombre)
                echo "<span class='error'> Campo vacío </span>";
            ?>
        </p>
        <p>
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario" id="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"];?>" maxlength="20"/>
            <?php
            if(isset($_POST["usuario"]) && $error_usuario)
                if($_POST["usuario"]=="")
                    echo "<span class='error'> Campo vacío </span>";
                else
                    echo "<span class='error'> Usuario repetido </span>";
            ?>
        </p>
        <p>
            <label for="clave">Contraseña:</label>
            <input type="password" name="clave" id="clave" value="" maxlength="20"/>
            <?php
            if(isset($_POST["clave"]) && $error_clave)
                echo "<span class='error'> Campo vacío </span>";
            ?>
        </p>
        <p>
            <label for="email">E-mail:</label>
            <input type="text" name="email" id="email" value="<?php if(isset($_POST["email"])) echo $_POST["email"];?>" maxlength="50"/>
            <?php
            if(isset($_POST["email"]) && $error_email)
            {
                if($_POST["email"]=="")
                    echo "<span class='error'> Campo vacío </span>";
                elseif(!filter_var($_POST["email"],FILTER_VALIDATE_EMAIL))
                    echo "<span class='error'> Email sintácticamente incorrecto </span>";
                else
                    echo "<span class='error'> Email repetido </span>";
            }
            ?>
        </p>
        <p>
            <button type="submit">Volver</button>
            <button type="submit" name="btnContinuarRegistro">Continuar</button>
        </p>
    </form>
</body>
</html>
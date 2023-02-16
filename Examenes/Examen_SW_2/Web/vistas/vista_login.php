<?php
if(isset($_POST["btnLogin"])){

    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";

    if(!$error_usuario && !$error_clave){

        $datos["usuario"] = $_POST["usuario"];
        $datos["clave"] = md5($_POST["clave"]);

        $url = DIR_SERV."/login";
        $respuesta = consumir_servicios_REST($url, "POST", $datos);
        $obj = json_decode($respuesta);

        if(!$obj){

            session_destroy();
            die(error_page("Error !obj", "<h1>Error !obj</h1><p>Error al consumir el servicio: ".$url."</p>".$respuesta));
        }

        if(isset($obj->error)){

            session_destroy();
            die(error_page("Error errores", "<h1>Error errores</h1><p>".$obj->error."</p>"));
        }

        if(isset($obj->mensaje)){

            $error_usuario = true;
        }else{

            $_SESSION["usuario"] = $datos["usuario"];
            $_SESSION["clave"] = $datos["clave"];
            $_SESSION["ultimo_acceso"] = time();
            header("Location:index.php");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
</head>
<body>
    <h1>Login Horarios</h1>
    <?php
    if(isset($_SESSION["seguridad"])){

        echo "<p>".$_SESSION["seguridad"]."</p>";
        unset($_SESSION["seguridad"]);
    }
    ?>
    <form action="index.php" method="post">
        <p>
            <label for="usuario" >Usuario: </label>
            <input type="text" name="usuario" id="usuario" <?php if(isset($_POST["usuario"])) echo $_POST["usuario"] ?> />
            <?php
            if(isset($_POST["btnLogin"]) && $error_usuario){

                if($_POST["usuario"] == ""){

                    echo "Campo obligatorio";
                }else{

                    echo "Usuario no encontrado en la BD";
                }
            }
            ?>
        </p>
        <p>
            <label for="clave" >Contraseña: </label>
            <input type="password" name="clave" id="clave" />
            <?php
            if(isset($_POST["btnLogin"]) && $error_clave){

                    echo "Campo obligatorio";
            }
            ?>
        </p>
        <p>
            <button name="btnLogin" >Entrar</button>
        </p>
    </form>
</body>
</html>
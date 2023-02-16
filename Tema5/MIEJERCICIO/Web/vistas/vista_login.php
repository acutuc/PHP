<?php
//Comprobamos errores:
if (isset($_POST["btnEntrar"])) {
    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";
    $error_form = $error_usuario || $error_clave;

    //Si no hay error, conectamos a la API login:
    if (!$error_form) {
        //Creamos la url del servicio:
        $url = DIR_SERV . "/login";
        //Guardamos los datos en un array:
        $datos_login["usuario"] = $_POST["usuario"];
        $datos_login["clave"] = md5($_POST["clave"]);
        //Creamos el objeto resultante de la petición al servicio en una variable:
        $respuesta = consumir_servicios_REST($url, "POST", $datos_login);
        //Creamos el json y lo guardamos en una variable:
        $obj = json_decode($respuesta);
        
        //Si no existe el objeto:
        if (!$obj) {
            session_destroy();
            die(error_page("Examen5 PHP", "<h1>Examen5 PHP</h1><p>Error consumiendo el servicio: " . $url . "</p>" . $respuesta));
        }

        //Si el objeto existe PERO tiene error:
        if (isset($obj->error)) {
            session_destroy();
            die(error_page("Examen5 PHP", "<h1>Examen5 PHP</h1><p>" . $obj->error . "</p>"));
        }

        //Si el objeto existe PERO contiene mensaje, es que el usuario o contraseña no existe:
        if (isset($obj->mensaje)) {
            $error_usuario = true;
        } else {
            //Si no ha ocurrido nada de lo anterior, está en la BD e iniciará sesión. Creamos las sesiones:
            $_SESSION["usuario"] = $datos_login["usuario"];
            $_SESSION["clave"] = $_POST["clave"];
            $_SESSION["ultimo_acceso"] = time();
            //Creamos la sesion de la api session:
            $_SESSION["api_session"]["api_session"] = $obj->api_session;
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
    <title>Examen SW 22_23</title>
</head>

<body>
    <h1>Video Club</h1>
    <?php
    if (isset($_SESSION["seguridad"])) {
        echo "<p class='seguridad'>" . $_SESSION["seguridad"] . "</p>";
        session_destroy();
    }
    ?>
    <form action="index.php" method="post">
        <p>
            <label for="usuario"><strong>Usuario: </strong></label>
            <input type="text" name="usuario" id="usuario" value="<?php if (isset($_POST["usuario"]))
                echo $_POST["usuario"] ?>">
                <?php
            if(isset($_POST["btnEntrar"])&& $error_usuario)
            {
                if($_POST["usuario"]=="")
                    echo "<span class='error'>* Campo vacío *</span>";
                else
                    echo "<span class='error'>* ".$obj->mensaje." *</span>";
            }
            ?>
            </p>
            <p>
                <label for="clave"><strong>Clave: </strong></label>
                <input type="password" name="clave" id="clave">
                <?php
                if(isset($_POST["btnEntrar"])&& $error_clave)
                {
                    echo "<span class='error'>* Campo vacío *</span>";
                }
                ?>
            </p>
            <p>
                <button type="submit" name="btnEntrar">Entrar</button>&nbsp;<button type="submit"
                    name="btnRegistrarse">Registrarse</button>
            </p>
        </form>
    </body>

    </html>
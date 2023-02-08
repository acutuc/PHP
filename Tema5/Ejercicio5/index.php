<?php
session_name("Login_Ejercicio5");
session_start();
function consumir_servicios_rest($url, $metodo, $datos = null)
{
    $llamada = curl_init();
    curl_setopt($llamada, CURLOPT_URL, $url);
    curl_setopt($llamada, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($llamada, CURLOPT_CUSTOMREQUEST, $metodo);
    if (isset($datos)) {
        curl_setopt($llamada, CURLOPT_POSTFIELDS, http_build_query($datos));
    }
    $respuesta = curl_exec($llamada);
    curl_close($llamada);
    return $respuesta;
}

function error_page($titulo, $cabecera, $cuerpo)
{
    return
        '<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>' . $titulo . '</title>
    </head>
    <body>
        <h1>' . $cabecera . '</h1>
        ' . $cuerpo . '</p>
    </body>
    </html>';
}

define("DIR_SERV", "http://localhost/PHP/Tema5/Ejercicio3/login_restful");

//Si hemos pulsado el botón salir una vez logueados:
if (isset($_POST["btnSalir"])) {
    session_destroy();
    header("Location:index.php");
    exit;
}

//Si existe sesión de usuario, es porque nos hemos logueado:
if (isset($_SESSION["usuario"])) {
    define("MINUTOS", 5);

    $datos_seguridad["usuario"] = $_SESSION["usuario"];
    $datos_seguridad["clave"] = $_SESSION["clave"];
    $url = DIR_SERV . "/login";
    $respuesta = consumir_servicios_REST($url, "POST", $datos_seguridad);
    $obj = json_decode($respuesta);

    //Si no hay objeto:
    if (!$obj) {
        session_destroy();
        die(error_page("Login Servicios", "Login Servicios", "<p>Error consumiendo el servicio: " . $url . "</p>" . $respuesta));
    }
    //Si el servicio nos devuelve error:
    if (isset($obj->error)) {
        die(error_page("Login Servicios", "Login Servicios", "<p>" . $obj->error . "</p>"));
    }

    //Si hay mensaje, nos han baneado.
    if (isset($obj->mensaje)) {
        session_unset();
        $_SESSION["seguridad"] = "Usted ya no se encuentra registrado en la BD";
        header("Location:index.php");
        exit;
    } else {
        $datos_usuario_log = $obj->usuario;
    }

    //Si no ocurre nada de lo anterior, vamos bien:
    if (time() - $_SESSION["ultimo_acceso"] > MINUTOS * 60) {
        session_unset();
        $_SESSION["seguridad"] = "Su tiempo de sesión ha expirado";
        header("Location:index.php");
        exit;
    }
    $_SESSION["ultimo_acceso"] = time();

    if ($datos_usuario_log->tipo == "admin") {
        ?>
        <!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <style>
                .enlinea {
                    display: inline
                }

                .enlace {
                    border: none;
                    background: none;
                    text-decoration: underline;
                    color: blue;
                    cursor: pointer
                }
            </style>
            <title>Login Servicios</title>
        </head>

        <body>
            <div>
                Bienvenido Admin<strong>
                    <?php echo $datos_usuario_log->usuario; ?>
                </strong> -
                <form class="enlinea" method="post" action="index.php">
                    <button class="enlace" name="btnSalir">Salir</button>
                </form>
            </div>

        </body>

        </html>
    <?php
    } else {
        ?>
        <!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <style>
                .enlinea {
                    display: inline
                }

                .enlace {
                    border: none;
                    background: none;
                    text-decoration: underline;
                    color: blue;
                    cursor: pointer
                }
            </style>
            <title>Login Servicios</title>
        </head>

        <body>
            <div>
                Bienvenido <strong>
                    <?php echo $datos_usuario_log->usuario; ?>
                </strong> -
                <form class="enlinea" method="post" action="index.php">
                    <button class="enlace" name="btnSalir">Salir</button>
                </form>
            </div>

        </body>

        </html>
    <?php
    }

    //Si no hay sesion, seguimos mostrando la ventana login.
} else {
    if (isset($_POST["btnLogin"])) {
        $error_usuario = $_POST["usuario"] == "";
        $error_clave = $_POST["clave"] == "";
        $error_form = $error_usuario || $error_clave;

        if (!$error_form) {
            //El array asociativo tiene que tener el mismo nombre que el parámetro que recibe:
            $datos_login["usuario"] = $_POST["usuario"];
            $datos_login["clave"] = md5($_POST["clave"]);
            $url = DIR_SERV . "/login";
            $respuesta = consumir_servicios_REST($url, "POST", $datos_login);
            $obj = json_decode($respuesta);

            //Si no hay objeto:
            if (!$obj) {
                die(error_page("Login Servicios", "Login Servicios", "<p>Error consumiendo el servicio: " . $url . "</p>" . $respuesta));
            }
            //Si el servicio nos devuelve error:
            if (isset($obj->error)) {
                die(error_page("Login Servicios", "Login Servicios", "<p>" . $obj->error . "</p>"));
            }

            //Si hay mensaje, es que tenemos usuario o contraseña incorrectas
            if (isset($obj->mensaje)) {
                $error_usuario = true;
                //Si no, está logueado y creamos variables de sesión:
            } else {
                $_SESSION["usuario"] = $datos_login["usuario"];
                $_SESSION["clave"] = $datos_login["clave"];
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
        <style>
            .error {
                color: red
            }
        </style>
        <title>Ejercicio 5</title>
    </head>

    <body>
        <h1>Login SW</h1>
        <form action="index.php" method="post">
            <p>
                <label for="usuario"><strong>Usuario: </strong></label>
                <input type="text" name="usuario" id="usuario" value="<?php if (isset($_POST["usuario"]))
                    echo $_POST["usuario"] ?>">
                <?php
                if (isset($_POST["btnLogin"]) && $error_usuario) {
                    if ($_POST["usuario"] == "") {
                        echo "<span class='error'>Campo vacío</span>";
                    } else {
                        echo "<span class='error'>Usuario o contraseña incorrectos</span>";
                    }
                }
                ?>
            </p>
            <p>
                <label for="clave"><strong>Contraseña: </strong></label>
                <input type="password" name="clave" id="clave">
                <?php
                if (isset($_POST["btnLogin"]) && $error_clave) {
                    if ($_POST["clave"] == "") {
                        echo "<span class='error'>Campo vacío</span>";
                    }
                }
                ?>
            </p>
            <p>
                <button type="submit" name="btnLogin" value="Login">Login</button>
            </p>
        </form>
        <?php
        if (isset($_SESSION["seguridad"])) {
            echo "<p class='error'>" . $_SESSION["seguridad"] . "</p>";
            session_destroy();
        }
        ?>
    </body>

    </html>
<?php
}
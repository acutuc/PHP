<?php
//Si pulsamos Entrar en el login inicial:
if (isset($_POST["btnEntrar"])) {
    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";

    $error_formulario = $error_usuario || $error_clave;

    //Si no hay error en formulario, iniciamos sesión:
    if (!$error_formulario) {
        //Conectamos a la BD:
        try {
            $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        } catch (PDOException $e) {
            die(error_page("Práctica Rec 2", "Práctica Rec 2", "Imposible conectar. Error: " . $e->getMessage()));
        }
        //Consultamos para ver si existe el usuario logueado:
        try {
            //Consulta:
            $consulta = "SELECT * FROM usuarios WHERE usuario = ? AND clave = ?";
            //Sentencia:
            $sentencia = $conexion->prepare($consulta);
            //Datos. Recogemos usuario y clave:
            $datos[] = $_POST["usuario"];
            $datos[] = md5($_POST["clave"]);
            //Ejecutamos la sentencia con los datos:
            $sentencia->execute($datos);

            //Si hemos obtenido tuplas, nos hemos logueado:
            if ($sentencia->rowCount() > 0) {
                //BORRO TODOS LOS $_POST PARA QUE NO ENTRE EN vista_login o vista_registro:
                unset($_POST); // <----------------------------------------------------------------- REVISAR
                //Almacenamos en $_SESSION los datos del usuario:
                $_SESSION["usuario"] = $datos[0];
                $_SESSION["clave"] = $datos[1];
                $_SESSION["ultimo_acceso"] = time();
                //Saltamos al inicio:
                header("Location:index.php");
                exit();
            } else {
                //Si no, el usuario no existe en la BD o la contraseña está mal escrita:
                $mensaje_error = "<span class='error'>*Usuario o contraseña incorrectos*</span>";
                $sentencia = null;
            }
        } catch (PDOException $e) {
            $sentencia = null; //Libera sentencia
            $conexion = null; //Cierra conexión
            die(error_page("Práctica Rec 2", "Práctica Rec 2", "Imposible conectar. Error: ".$e->getMessage()));
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
        .form {
            display: flex;
            justify-content: space-between;
            width: 300px;
        }

        .botones {
            display: flex;
            justify-content: space-around;
            padding-left: 40px;
            width: 200px;
        }

        .error {
            color: red;
        }
    </style>
    <title>Práctica Rec 2</title>
</head>

<body>
    <h1>Práctica Rec 2</h1>
    <form action="index.php" method="post">
        <p class="form">
            <label for="usuario">Usuario: </label><input type="text" id="usuario" name="usuario" value="<?php if (isset($_POST["usuario"]))
                echo $_POST["usuario"] ?>">
                <?php
            if (isset($_POST["btnEntrar"]) && $error_usuario) {
                echo "<span class='error'>*Campo vacío*</span>";
            }
            ?>
        </p>
        <p class="form">
            <label for="clave">Contraseña: </label><input type="password" id="clave" name="clave">
            <?php
            if (isset($_POST["btnEntrar"]) && $error_clave) {
                if ($_POST["clave"] == "") {
                    echo "<span class='error'>*Campo vacío*</span>";
                } else {
                    echo "<span class='error>*Contraseña incorrecta*</span>";
                }
            }
            if (isset($mensaje_error)) {
                echo "<p>" . $mensaje_error . "</p>";
            }
            ?>
        </p>
        <p class="botones">
            <button type="submit" name="btnEntrar">Entrar</button><button type="submit"
                name="btnRegistrarse">Registarse</button>
        </p>
    </form>
</body>

</html>
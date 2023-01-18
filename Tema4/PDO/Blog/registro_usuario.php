<?php
session_name("Blog_Curso22_23");
session_start();

require "src/config_bd.php";

function error_page($title, $encabezado, $mensaje)
{
    return '<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>' . $title . '</title>
    </head>
    <body>
        <h1>' . $encabezado . '</h1>
        ' . $mensaje . '
    </body>
    </html>';
}

if (isset($_POST["btnContinuar"])) {
    $error_nombre = $_POST["nombre"] == "";
    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";
    $error_email = $_POST["email"] == "";

    $error_formulario = $error_nombre || $error_usuario || $error_clave || $error_email;

    //Si no hay error en el formulario, conectamos para comprobar que no haya un usuario con los mismos datos:
    if (!$error_formulario) {
        try {
            $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        } catch (PDOException $e) {
            die(error_page("Blog Personal", "Nuevo usuario", "Imposible conectar. Error: " . $e->getMessage()));
        }

        //Hacemos la consulta a la BD:
        try {
            $consulta = "SELECT * FROM usuarios WHERE usuario = ? OR email = ?";
            //Preparamos la consulta:
            $sentencia = $conexion->prepare($consulta);

            //Metemos los datos en un array.
            $datos[] = $_POST["usuario"];
            $datos[] = $_POST["email"];

            //Ejecutamos la sentencia:
            $sentencia->execute($datos);

            //Si existen tuplas, hay duplicado:
            if ($sentencia->rowCount() > 0) {
                $error_usuario = true;

                //Si no, podemos registrar el usuario, realizando una nueva consulta:
            } else {
                unset($datos);
                $consulta = "INSERT INTO usuarios (usuario, clave, nombre, email) VALUES (?, ?, ?, ?)";

                //Preparamos la consulta:
                $sentencia = $conexion->prepare($consulta);

                //Metemos los datos en un array.
                $datos[] = $_POST["usuario"];
                $datos[] = md5($_POST["clave"]);
                $datos[] = $_POST["nombre"];
                $datos[] = $_POST["email"];

                //Ejecutamos la sentencia:
                $sentencia->execute($datos);

                $mensaje = "Usuario registrado con éxito";
            }
        } catch (PDOException $e) {
            $conexion = null;
            $sentencia = null;
            die(error_page("Blog Personal", "Nuevo usuario", "Imposible conectar. Error: " . $e->getMessage()));
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
    <link rel="stylesheet" href="estilos/estilos.css">
    <title>Blog Personal</title>
</head>

<body>
    <h1>Nuevo usuario</h1>
    <form action="registro_usuario.php" method="post">
        <p>
            <label for="nombre"><strong>Nombre: </strong></label><input type="text" id="nombre" name="nombre" value="<?php if (isset($_POST["nombre"]))
                echo $_POST["nombre"] ?>">
                <?php
            if (isset($_POST["btnContinuar"]) && $error_nombre) {
                echo "<span class='error'>*Campo vacío*</span>";
            }
            ?>
        </p>
        <p>
            <label for="usuario"><strong>Usuario: </strong></label><input type="text" id="usuario" name="usuario" value="<?php if (isset($_POST["usuario"]))
                echo $_POST["usuario"] ?>">
                <?php
            if (isset($_POST["btnContinuar"]) && $error_usuario) {
                if ($_POST["usuario"] == "") {
                    echo "<span class='error'>*Campo vacío*</span>";
                }
            }
            ?>
        </p>
        <p>
            <label for="clave"><strong>Contraseña: </strong></label><input type="password" id="clave" name="clave">
            <?php
            if (isset($_POST["btnContinuar"]) && $error_clave) {
                echo "<span class='error'>*Campo vacío*</span>";
            }
            ?>
        </p>
        <p>
            <label for="email"><strong>Email: </strong></label><input type="email" id="email" name="email" value="<?php if (isset($_POST["email"]))
                echo $_POST["email"] ?>">
                <?php
            if (isset($_POST["btnContinuar"]) && $error_email) {
                echo "<span class='error'>*Campo vacío*</span>";
            }
            ?>
        </p>
        <?php
        if (isset($mensaje)) {
            echo "<p>$mensaje</p>";
        }

        if(isset($_POST["btnContinuar"]) && $error_usuario){
            if($error_usuario != ""){
                echo "<span class='error'>*El usuario o email ya se encuentra registrado*</span>";
            }
        }
        ?>
        <p>
            <button type="submit" formaction="index.php">Atrás</button>
            <button type="submit" name="btnContinuar">Continuar</button>
        </p>

    </form>
</body>

</html>
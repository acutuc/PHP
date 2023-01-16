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

//Si hay sesión (de cualquier campo):
if(isset($_SESSION["usuario"])){
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        die(error_page("Login PDO", "Login con PDO", "<p>Imposible conectar. Error: " . $e->getMessage() . "</p></body></html>"));
    }
}

if (isset($_POST["btnEntrar"])) {
    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";

    $error_formulario = $error_usuario || $error_clave;

    //Si no hay error en el formulario, conectamos...
    if (!$error_formulario) {
        //Conectamos a la BD.
        try {
            $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        } catch (PDOException $e) {
            die(error_page("Blog Personal", "Blog Personal", "<p>Imposible conectar. Error: " . $e->getMessage() . "</p></body></html>"));
        }
    }

    //... y miramos si existe el usuario: 
    try {
        $consulta = "SELECT * FROM usuarios WHERE usuario = ? AND clave = ?";

        $sentencia = $conexion->prepare($consulta);

        $datos[] = $_POST["usuario"];
        $datos[] = md5($_POST["clave"]);

        $sentencia->execute($datos);

        //Si se ha logeado, creamos los $_SESSION
        if ($sentencia->rowCount() > 0) {
            $_SESSION["usuario"] = $datos[0];
            $_SESSION["clave"] = $datos[1];
            $_SESSION["ultimo_acceso"] = time();

            header("Location:index.php");
            exit();
        } else {
            //Si no se ha logeado, ponemos a true el $error_usuario:
            $error_usuario = true;
        }
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        die(error_page("Blog Personal", "Blog Personal", "<p>Imposible conectar. Error: " . $e->getMessage() . "</p></body></html>"));
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="estilos/estilos.css" rel="stylesheet">
    <title>Blog Personal</title>
</head>

<body>
    <h1>Blog Personal</h1>

    <form action="index.php" method="post">
        <p>
            <label for="usuario">Nombre de usuario: </label>
            <input type="text" id="usuario" name="usuario" value="<?php if (isset($_POST["usuario"]))
                echo $_POST["usuario"] ?>">
            <?php
            if (isset($_POST["btnEntrar"]) && $error_usuario) {
                if ($_POST["usuario"] == "") {
                    echo "<span class='error'>*Campo vacío*</span>";
                } else {
                    echo "<span class='error'>*Usuario o contraseña mal escritos*</span>";
                }
            }
            ?>
        </p>
        <p>
            <label for="clave">Contraseña: </label>
            <input type="password" id="clave" name="clave">
            <?php
            if (isset($_POST["btnEntrar"]) && $error_clave) {
                echo "<span class='error'>*Campo vacío*</span>";
            }
            ?>
        </p>
        <p>
            <button type="submit" name="btnEntrar">Entrar</button>
            <button type="submit" name="btnRegistrarse" formaction="registro_usuario.php">Registrarse</button>
        </p>
    </form>
    <?php
    //1. Conectamos a la BD.
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        die("<p>Imposible conectar. Error: " . $e->getMessage() . "</p></body></html>");
    }

    //2. Hacemos la consulta para mostrar las noticias.
    try {
        $consulta = "SELECT * FROM noticias ORDER BY noticias.fPublicacion DESC";

        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
        $respuesta = $sentencia->fetchAll(PDO::FETCH_ASSOC);

        if ($sentencia->rowCount() > 0) { //Si hemos obtenido tuplas:
            echo "<h2>Noticias</h2>";

            foreach ($respuesta as $tupla) {
                echo "<button type='submit' name='btnNoticia' class='noticia'>" . $tupla["titulo"] . "</button>";
                echo "<p>" . $tupla["copete"] . "</p>";
                echo "<br>";
            }
        }

        $sentencia = null;
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        die("<p>Imposible conectar. Error: " . $e->getMessage() . "</p></body></html>");
    }



    ?>
</body>

</html>
<?php
session_name("Blog_Curso22_23");
session_start();

require "src/config_bd.php";

//Si pulsamos al botón salir:
if(isset($_POST["btnSalir"])){
    session_destroy();
    header("Location:index.php");
    exit();
}

//Si hay sesión (de cualquier campo):
if (isset($_SESSION["usuario"])) {
    
    require "vistas/seguridad.php";

    if ($datos_usuario_log["tipo"] == "admin") { //Si somos admin:
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
            <h1>Blog Personal</h1>
            <form action="index.php" method="post">
            Bienvenido <?php echo "<strong>".$datos_usuario_log["usuario"]."</strong> - "; ?>
                <button type="submit" name="btnSalir" class="salir">Salir</button>
            </form>
        </body>
        </html>
        <?php
    }
} else {


    //Si pulsamos el botón ENTRAR:
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
                    //Si no se ha logeado (ha expirado el tiempo de sesion), ponemos a true el $error_usuario:
                    $error_usuario = true;
                }
            } catch (PDOException $e) {
                $sentencia = null;
                $conexion = null;
                die(error_page("Blog Personal", "Blog Personal", "<p>Imposible conectar. Error: " . $e->getMessage() . "</p></body></html>"));
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
        <link href="estilos/estilos.css" rel="stylesheet">
        <title>Blog Personal</title>
    </head>

    <body>
        <h1>Blog Personal</h1>
        <?php
        if (isset($_SESSION["mensaje"])) {
            echo $_SESSION["mensaje"];
        }
        
        if(isset($_SESSION["seguridad"])){
            echo $_SESSION["seguridad"];

            unset($_SESSION["seguridad"]);
        }
        ?>
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

        //Si pulsamos en una NOTICIA:
        if (isset($_POST["btnNoticia"])) {
            //Conectamos:
            try {
                $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
            } catch (PDOException $e) {
                die(error_page("Blog Personal", "Blog Personal", "Imposible conectar. Error: " . $e->getMessage()));
            }

            //Hacemos consulta:
            try {
                $consulta = "SELECT * FROM noticias, usuarios, categorias 
        WHERE noticias.idNoticia = ? AND noticias.idUsuario = usuarios.idUsuario AND noticias.idCategoria = categorias.idCategoria";

                //Preparamos la sentencia:
                $sentencia = $conexion->prepare($consulta);

                //Metemos los datos en un array:
                $datos[] = $_POST["btnNoticia"];

                //Ejecutamos la sentencia:
                $sentencia->execute($datos);

                //Almacenamos los datos en $respuesta:
                $respuesta = $sentencia->fetch(PDO::FETCH_ASSOC);

                echo "<h3>" . $respuesta["titulo"] . "</h3>";
                echo "<p>Publicado por <strong>" . $respuesta["usuario"] . "</strong> en <em>" . $respuesta["valor"] . "</em></p>";
                echo "<p>" . $respuesta["copete"] . "</p>";
                echo "<p>" . $respuesta["cuerpo"] . "</p>";

                $consulta = "SELECT * FROM comentarios, usuarios
            WHERE comentarios.idNoticia = ? AND comentarios.idUsuario = usuarios.idUsuario";

                $sentencia = $conexion->prepare($consulta);

                //$datos está preparado más arriba!!
                //Ejecutamos la sentencia:
                $sentencia->execute($datos);

                //Almaceno los datos en $respuesta:
                $respuesta = $sentencia->fetchAll(PDO::FETCH_ASSOC);

                //Si hay tuplas, es que hay comentarios y mostramos:
                if ($respuesta) {
                    echo "<h3>Comentarios</h3>";

                    foreach ($respuesta as $tupla) {
                        echo "<p><strong>" . $tupla["usuario"] . "</strong> dijo:";
                        echo "<br>";
                        echo $tupla["comentario"];
                        echo "</p>";
                    }
                } else {
                    echo "<p><strong>No hay comentarios.</strong></p>";
                }

                //Botón Volver:
                echo "<form action='index.php'>";
                echo "<button type='submit' >Volver</button>";
                echo "</form>";

            } catch (PDOException $e) {
                $sentencia = null;
                $conexion = null;
                die(error_page("Blog Personal", "Blog Personal", "Imposible conectar. Error: " . $e->getMessage()));
            }
        } else {
            //2. Hacemos la consulta para mostrar las noticias.
            try {
                $consulta = "SELECT * FROM noticias ORDER BY noticias.fPublicacion DESC";

                $sentencia = $conexion->prepare($consulta);
                $sentencia->execute();
                $respuesta = $sentencia->fetchAll(PDO::FETCH_ASSOC);

                if ($sentencia->rowCount() > 0) { //Si hemos obtenido tuplas:
                    echo "<h2>Noticias</h2>";
                    echo "<form action='index.php' method='post'>";
                    foreach ($respuesta as $tupla) {
                        echo "<button type='submit' name='btnNoticia' class='noticia' value='" . $tupla["idNoticia"] . "'>" . $tupla["titulo"] . "</button>";
                        echo "<p>" . $tupla["copete"] . "</p>";
                        echo "<br>";
                    }
                    echo "</form>";
                }

                $sentencia = null;
            } catch (PDOException $e) {
                $sentencia = null;
                $conexion = null;
                die("<p>Imposible conectar. Error: " . $e->getMessage() . "</p></body></html>");
            }
        }



        ?>
    </body>
    <?php
}
?>

</html>
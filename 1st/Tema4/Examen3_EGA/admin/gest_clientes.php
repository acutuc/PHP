<?php
if (isset($_POST["btnEditar"])) {
    $_SESSION["mensaje_accion"] = "El cliente con id " . $_POST["btnEditar"] . " fue editado con éxito.";
    header("Location:index.php");
    exit;
}

if (isset($_POST["btnBorrar"])) {
    $_SESSION["mensaje_accion"] = "El cliente con id " . $_POST["btnBorrar"] . " fue borrado con éxito.";
    header("Location:index.php");
    exit;
}

if (isset($_POST["btnAgregar"])) {
    $error_agregar_usuario_usuario = $_POST["agregarUsuario"] == "";
    $error_agregar_usuario_clave = $_POST["claveUsuario"] == "";

    $error_agregar_usuario_formulario = $error_agregar_usuario_usuario || $error_agregar_usuario_clave;

    //Si no hay error:
    if (!$error_agregar_usuario_formulario) {
        //Conectamos
        try {
            $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        } catch (PDOException $e) {
            die(error_page("Videoclub", "Videoclub", "Imposible conectar. Error: " . $e->getMessage()));
        }

        //Consultamos:
        try {
            $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        } catch (PDOException $e) {
            die(error_page("Videoclub", "Videoclub", "Imposible conectar. Error: " . $e->getMessage()));
        }

        //Hacemos la consulta y comprobamos si no hay duplicado en la BD:
        try {
            $consulta = "SELECT * FROM clientes WHERE usuario = ? AND clave = ?";

            //Preparamos la sentencia:
            $sentencia = $conexion->prepare($consulta);

            $datos[] = $_POST["agregarUsuario"];
            $datos[] = md5($_POST["claveUsuario"]);

            //Ejecutamos la sentencia:
            $sentencia->execute($datos);

            //Si NO obtenemos tuplas, podemos registrar:
            if ($sentencia->rowCount() < 1) {
                //Hacemos nueva consulta de inserción a la BD:
                try {
                    //Utilizamos las mismas variables para machacar:
                    $consulta = "INSERT INTO clientes (usuario, clave) VALUES (?, ?)";

                    //Preparamos la sentencia:
                    $sentencia = $conexion->prepare($consulta);

                    //Utilizamos los mismos datos de $datos y ejecutamos
                    $sentencia->execute($datos);
                } catch (PDOException $e) {
                    $sentencia = null;
                    $conexion = null;
                    die(error_page("Videoclub", "Videoclub", "Imposible conectar. Error: " . $e->getMessage()));
                }
            } else {
                //Si obtenemos tuplas, hay un usuario ya registrado con ese nick:
                $error_agregar_usuario_usuario = true;
            }
        } catch (PDOException $e) {
            $sentencia = null;
            $conexion = null;
            die(error_page("Videoclub", "Videoclub", "Imposible conectar. Error: " . $e->getMessage()));
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
    <title>Videoclub</title>
</head>

<body>
    <h1>Videoclub</h1>
    <form action="index.php" method="post">
        <p>
            Bienvenido <strong>
                <?php echo $tupla["usuario"]; ?>
            </strong> -
            <button type="submit" name="btnSalir">Salir</button>
        </p>
    </form>
    <h2>Clientes</h2>
    <?php
    if (isset($_SESSION["mensaje_accion"])) {
        echo $_SESSION["mensaje_accion"];

        //Hacemos unset para que no vuelva a salir al recargar:
        unset($_SESSION["mensaje_accion"]);
    }
    ?>
    <h3>Listado de los clientes (no 'admin')</h3>
    <table>
        <tr>
            <th>Usuario</th>
            <th>FOTO</th>
        </tr>
        <?php
        try {
            $consulta = "SELECT * FROM clientes WHERE tipo = 'normal'";

            //Preparamos la sentencia:
            $sentencia = $conexion->prepare($consulta);

            //Ejecutamos la sentencia:
            $sentencia->execute();

            $respuesta = $sentencia->fetchAll(PDO::FETCH_ASSOC);

            unset($tupla);
            foreach ($respuesta as $tupla) {
                echo "<tr>";

                echo "<td>" . $tupla["usuario"] . "</td>";
                echo "<td>" . $tupla["foto"] . "</td>";
                echo "<td>";
                echo "<form action='index.php' method='post'>";
                echo "<button type='submit' name='btnEditar' value='" . $tupla["id_cliente"] . "'>Editar</button> - ";
                echo "<button type='submit' name='btnBorrar' value='" . $tupla["id_cliente"] . "'>Borrar</button>";
                echo "</form>";
                echo "</td>";

                echo "</tr>";
            }
        } catch (PDOException $e) {
            $sentencia = null;
            $conexion = null;
            die(error_page("Videoclub", "Videoclub", "Imposible conectar. Error: " . $e->getMessage()));
        }
        ?>
    </table>
    <h3>Agregar nuevo usuario</h3>
    <form action="index.php" method="post">
        <p>
            <label for="agregarUsuario">Nombre del usuario</label>
        </p>
        <p>
            <input type="text" id="agregarUsuario" name="agregarUsuario" value="<?php if (isset($_POST["agregarUsuario"]))
                echo $_POST["agregarUsuario"] ?>">
            <?php
            if (isset($_POST["btnAgregar"]) && $error_agregar_usuario_usuario) {
                if ($_POST["agregarUsuario"] == "") {
                    echo "<span class='error'>*Campo vacío*</span>";
                } else {
                    echo "<span class='error'>*El usuario ya se encuentra registrado en la BD.</span>";
                }

            }
            ?>
        </p>
        <p>
            <label for="claveUsuario">Clave del usuario</label>
        </p>
        <p>
            <input type="password" id="claveUsuario" name="claveUsuario">
            <?php
            if (isset($_POST["btnAgregar"]) && $error_agregar_usuario_clave) {
                echo "<span class='error'>*Campo vacío*</span>";
            }
            ?>
        </p>
        <p>
            <input type="file" name="fotoUsuario" accept="images/*">
        </p>
        <p>
            <button type="submit" name="btnAgregar">Agregar cliente</button>
        </p>
    </form>
</body>

</html>
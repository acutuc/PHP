<?php
require "src/bd_config.php";
require "src/funciones.php";

if (isset($_POST["btnContinuarRegistro"])) {
    $error_usuario = $_POST["usuario"] == "";

    if (!$error_usuario) { //Si no hay error, conectamos y miramos si no está en la BD.
        try {
            $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {
            die(error_page("Examen 18/19", "Video Club", "Imposible conectar. Error Nº " . mysqli_connect_errno() . " : " . mysqli_connect_error()));
        }

        $error_usuario = repetido($conexion, "clientes", "usuario", $_POST["usuario"]);
        if (is_string($error_usuario)) { //Si hay string, hay error.
            mysqli_close($conexion);
            die(error_page("Examen 18/19", "Video Club", $error_usuario));
        }
    }
    $error_clave = $_POST["clave"] == "";
    $error_clave2 = $_POST["clave"] != $_POST["clave2"];

    $error_foto = $_FILES["foto"]["name"] != "" && ($_FILES["foto"]["error"] || !getimagesize($_FILES["foto"]["tmp_name"]) || $_FILES["foto"]["size"] > 500000);

    $error_form_registro = $error_usuario || $error_clave || $error_clave2 || $error_foto;

    if (!$error_form_registro) {
        try {
            $consulta = "INSERT INTO clientes(usuario, clave) VALUES('" . $_POST["usuario"] . "','" . md5($_POST["clave"]) . "')";
            mysqli_query($conexion, $consulta);
        } catch (Exception $e) {
            mysqli_close($conexion);
            die(error_page("Examen 18/19", "Video Club", "Imposible conectar. Error Nº " . mysqli_errno($conexion) . " : " . mysqli_error($conexion)));
        }
        //Cambiamos el nombre de la imagen y la ubicación:
        $mensaje_registro = "Usuario registrado con éxito";

        if ($_FILES["foto"]["name"] != "") {
            $ultimo_id = mysqli_insert_id($conexion); //Nos da la última id con la que se hizo la última inserción a la BD.

            $var_nombre = explode(".", $_FILES["foto"]["tmp_name"]);
            $extension = "";
            if (count($var_nombre) > 1) { //Si true, hay extensión
                $extension = "." . end($var_nombre);
            }
            $nombre_foto = "img" . $ultimo_id . $extension;

            @$var = move_uploaded_file($_FILES["foto"]["tmp_name"], "Images/" . $nombre_foto);

            if ($var) {
                try {
                    $consulta = "UPDATE clientes SET foto = '".$nombre_foto."' WHERE id_cliente = '".$ultimo_id."'";
                    mysqli_query($conexion, $consulta);
                } catch (Exception $e) {
                    if(is_file("Images/".$nombre_foto)){
                        unlink("Images/".$nombre_foto);
                    }
                    mysqli_close($conexion);
                    die(error_page("Examen 18/19", "Video Club", "Imposible conectar. Error Nº " . mysqli_errno($conexion) . " : " . mysqli_error($conexion)));
                }
            }else{
                $mensaje_registro = "Usuario registrado con éxito, con la imagen por defecto por un problema en el servidor";
            }
        }

        session_name("Examen_18_19");
        session_start();

        $_SESSION["usuario"] = $_POST["usuario"];
        $_SESSION["clave"] = md5($_POST["clave"]);
        $_SESSION["ultimo_acceso"] = time();
        $_SESSION["mensaje_registro"] = $mensaje_registro;
        header("Location:clientes.php");
        exit;
    }
}
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
    <form method="post" action="registro_usuario.php" enctype="multipart/form-data">
        <p>
            <label for="usuario">Usuario: </label>
            <input type="text" name="usuario" id="usuario" value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"] ?>">
            <?php
            if (isset($_POST["btnContinuarRegistro"]) && $error_usuario) {
                if ($_POST["usuario"] == "") {
                    echo "<span class='error'>* Campo vacío *</span>";
                } else {
                    echo "<span class='error'>* Usuario repetido *</span>";
                }
            }
            ?>
        </p>
        <p>
            <label for="clave">Contraseña: </label>
            <input type="password" name="clave" id="clave">
            <?php
            if (isset($_POST["btnContinuarRegistro"]) && $error_clave) {
                if ($_POST["clave"] == "") {
                    echo "<span class='error'>* Campo vacío *</span>";
                }
            }
            ?>
        </p>
        <p>
            <label for="clave2">Repita contraseña: </label>
            <input type="password" name="clave2" id="clave2">
            <?php
            if (isset($_POST["btnContinuarRegistro"]) && $error_clave2) {
                if ($_POST["clave2"] == "") {
                    echo "<span class='error'>* No has repetido bien la clave *</span>";
                }
            }
            ?>
        </p>
        <p>
            <label for="foto">Foto (Máx 500KB): </label>
            <input type="file" name="foto" id="foto" accept="image/*">
            <?php
            if (isset($_POST["btnContinuarRegistro"]) && $error_foto) {
                if ($_FILES["foto"]["error"]) {
                    echo "<span class='error'>* Error subiendo foto al servidor *</span>";
                } elseif (!getimagesize($_FILES["foto"]["tmp_name"])) {
                    echo "<span class='error'>* No has elegido un fichero de tipo imagen *</span>";
                } else {
                    echo "<span class='error'>* El tamaño del fichero elegido es superior a 500KB *</span>";
                }
            }
            ?>
        </p>
        <p>
            <button type="submit" formaction="index.php">Volver</button>
            <button type="submit" name="btnContinuarRegistro">Continuar</button>
        </p>
    </form>
</body>

</html>
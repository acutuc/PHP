<?php
require "src/ctes_funciones.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        td,
        th {
            border: 1px solid black;
            text-align: center;
            padding: 10px;
        }

        th {
            background-color: lightgrey;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        .enlace {
            background: none;
            border: none;
            color: blue;
            text-decoration: underline;
            cursor: pointer;
        }

        img {
            height: 100px;
            width: 100px;
        }

        .error{
            color:red;
        }
    </style>
    <title>Práctica 8</title>
</head>

<body>
    <h1>Práctica 8</h1>
    <?php
    //2. Si hemos pulsado en el nombre de un usuario, listamos sus datos:
    if (isset($_POST["btnDetallesUsuario"])) {
        //Nueva conexión:
        if (!isset($conexion)) {
            try {
                $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
                mysqli_set_charset($conexion, "utf8");
            } catch (Exception $e) {
                die("<p>Imposible conectar. Error: " . $e->getMessage() . "</p></body></html>");
            }
        }

        try {
            $consulta = "SELECT * FROM usuarios WHERE id_usuario = " . $_POST["btnDetallesUsuario"];
            $resultado = mysqli_query($conexion, $consulta);
        } catch (Exception $e) {
            mysqli_close($conexion);
            die("<p>No se ha podido realizar la consulta. " . $e->getMessage() . "</p></body></html>");
        }

        echo "<h3>Detalles del usuario <em>" . $_POST["nombreUsuario"] . "</em></h3>";
        //Comprobamos si se ha borrado el usuario de la BD.
        if (mysqli_num_rows($resultado) > 0) {
            //Recogemos sus datos:
            $datos_usuario = mysqli_fetch_assoc($resultado);
            mysqli_free_result($resultado);

            echo "<p><strong>ID de usuario:</strong> " . $datos_usuario["id_usuario"] . "</p>";
            echo "<p><strong>DNI:</strong> " . $datos_usuario["dni"] . "</p>";
            echo "<p><strong>Sexo:</strong> " . $datos_usuario["sexo"] . "</p>";
            echo "<p><img src='Img/" . $datos_usuario["foto"] . "' alt='Foto usuario' title='Foto usuario'></p>";
        } else {
            echo "<p>El usuario seleccionado ya no se encuentra registrado en la BD.</p>";
        }
    }

    //3. Si hemos pulsado borrar un usuario:
    if (isset($_POST["btnBorrarUsuario"])) {
        //Si no hay una conexión abierta, creamos una nueva:
        if (!isset($conexion)) {
            try {
                $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
                mysqli_set_charset($conexion, "utf8");
            } catch (Exception $e) {
                die("<p>Imposible conectar. Error: " . $e->getMessage() . "</p></body></html>");
            }
        }

        //Hacemos la consulta para eliminar el usuario de la BD:
        try {
            $consulta = "DELETE FROM usuarios WHERE id_usuario = " . $_POST["btnBorrarUsuario"];
            $resultado = mysqli_query($conexion, $consulta);
        } catch (Exception $e) {
            mysqli_close($conexion);
            die("<p>No se ha podido realizar la consulta a la BD. " . $e->getMessage() . "</p></body></html>");
        }

        $mensaje_accion = "Usuario eliminado de la BD con éxito";
    }

    //4. Si hemos pulsado añadir un usuario:
    if (isset($_POST["btnUsuarioNuevo"])) {
        $error_nombre = $_POST["nombre"] == "";
        $error_usuario = $_POST["usuario"] == "" || is_repetido($_POST["usuario"]);
        $error_clave = $_POST["clave"] == "";
        $error_dni = strlen($_POST["dni"]) !== 9;
    ?>
        <h3>Agregar nuevo usuario</h3>
        <p>
            <label for="nombre">Nombre:</label><br>
            <input type="text" name="nombre" id="nombre" value="<?php if (isset($_POST["nombre"])) echo $_POST["nombre"] ?>" placeholder="Nombre..." />
            <?php
            if(isset($_POST["btnContinuarAgregar"]) && $error_nombre){
                echo "<span class='error'>*Campo vacío*</span>";
            }
            ?>
        </p>
    <?php
    }

    if (isset($mensaje_accion)) {
        echo "<p>" . $mensaje_accion . "</p>";
    }
    ?>
    <h3>Listado de los usuarios</h3>
    <?php


    //1. Conexión para listar:
    if (!isset($conexion)) {
        try {
            $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {
            die("<p>Imposible conectar. Error: " . $e->getMessage() . "</p></body></html>");
        }
    }

    //1.1. Consulta para listar:
    try {
        $consulta = "SELECT * FROM usuarios";
        $resultado = mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        mysqli_close($conexion);
        die("<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p></body></html>");
    }

    //1.2. Construimos la tabla para listar:
    echo "<table>";
    echo "<tr><th>#</th><th>Foto</th><th>Nombre</th><th><form method='post' action='index.php' enctype='multipart-form/data'><button type='submit' name='btnUsuarioNuevo' class='enlace'>Usuario +</button></form></th></tr>";
    while ($tupla = mysqli_fetch_assoc($resultado)) {
        echo "<tr>";
        echo "<td>" . $tupla["id_usuario"] . "</td>";
        echo "<td><img src='Img/" . $tupla["foto"] . "' title='Foto usuario' alt='Foto usuario'></td>";
        echo "<td><form method='post' action='index.php'><input type='hidden' name='nombreUsuario' value='" . $tupla["nombre"] . "'/><button type='submit' name='btnDetallesUsuario' value='" . $tupla["id_usuario"] . "'class='enlace'>" . $tupla["nombre"] . "</button></form></td>";
        echo "<td><form method='post' action='index.php'><button type='submit' name='btnBorrarUsuario' value='" . $tupla["id_usuario"] . "' class='enlace'>Borrar</button> - <button type='submit' name='btnEditarUsuario' class='enlace'>Editar</button></form></td>";
        echo "</tr>";
    }
    echo "</table>";
    mysqli_free_result($resultado);

    mysqli_close($conexion);
    /*
    //PARA COGER LA ÚLTIMA ID AUTO-INCREMENT INSERTADA:
    mysqli_insert_id($conexion);

    //ELIMINAR IMAGEN DE UN USUARIO:
    unlink("archivo.jpg")
    */
    ?>
</body>

</html>
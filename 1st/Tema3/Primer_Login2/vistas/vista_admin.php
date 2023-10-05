<?php
if (isset($_POST["btnSalir"])) {
    session_destroy();
    header("Location:index.php");
    exit;
}

if (isset($_POST["btnBorrar"])) {
    $consulta = "DELETE FROM usuarios WHERE id_usuario = '" . $_POST["btnBorrar"] . "'";
    mysqli_query($conexion, $consulta);

    $mensaje_accion = "Usuario borrado con éxito";
}

if(isset($_POST["btnContinuarAgregar"])){
    $error_nombre = $_POST["nombre"] == "";
        $error_usuario = $_POST["usuario"] == "";
        $error_clave = $_POST["clave"] == "";
        $error_email = $_POST["email"] || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primer Login</title>
    <style>
        .enlace {
            border: none;
            background: none;
            text-decoration: underline;
            color: blue;
            cursor: pointer
        }

        .enlinea {
            display: inline
        }

        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        th {
            background-color: lightgrey;
        }

        td {
            padding: 10px;
        }

        img {
            height: 100px;
            width: 100px;
        }
        
    </style>
</head>

<body>
    <h1>Primer Login</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usuario_log["usuario"]; ?></strong> -
        <form class="enlinea" action="index.php" method="post">
            <button class='enlace' name='btnSalir'>Salir</button>
        </form>
    </div>
    <?php
    $consulta = "SELECT * FROM usuarios WHERE tipo = 'normal'";
    $resultado = mysqli_query($conexion, $consulta);
    ?>
    <br>
    <table>
        <tr>
            <th>Nombre de Usuario <form action='index.php' method='post'><button class='enlace' type='submit' name='btnAgregar'>Agregar nuevo usuario</button></form></th>
            <th>Borrar</th>
            <th>Editar</th>
        </tr>
        <?php
        while ($tupla = mysqli_fetch_assoc($resultado)) {
            echo "<tr>";

            echo "<td>" . $tupla["usuario"] . "</td>";
            echo "<td><form action='index.php' method='post'><button type='submit' name='btnBorrar' value='" . $tupla["id_usuario"] . "'><img src='img/borrar.png' alt='Borrar usuario' title='Borrar usuario'></button></form></td>";
            echo "<td><form action='index.php' method='post'><button type='submit' name='btnEditar' value='" . $tupla["id_usuario"] . "'><img src='img/editar.png' alt='Editar usuario' title='Editar usuario'></button></form></td>";

            echo "</tr>";
        }
        ?>
    </table>

    <?php
    mysqli_free_result($resultado);

    if (isset($_POST["btnAgregar"]) || isset($_POST["btnContinuarAgregar"])) {
    ?>
        <form action='index.php' method='post'>
            <p>
                <label for="nombre"><strong>Nombre: </strong></label>
                <input type="text" name="nombre" id="nombre" value="<?php if(isset($_POST["nombre"])) echo $_POST["nombre"] ?>"><br>
            </p>
            <label for="usuario"><strong>Usuario: </strong></label>
            <input type="text" name="usuario" id="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"] ?>"><br>
            <p>
                <label for="clave"><strong>Contraseña: </strong></label>
                <input type="password" name="clave" id="clave"><br>
            </p>
            <label for="email"><strong>Email: </strong></label>
            <input type="text" name="email" id="email" value="<?php if(isset($_POST["email"])) echo $_POST["email"] ?>"><br>
            <p>
                <button type="submit" name="btnAtras">Atrás</button>&nbsp;
                <button type="submit" name="btnContinuarAgregar">Continuar</button>
            </p>
        </form>

    <?php
    }

    if (isset($_POST["btnEditar"])) {
        echo "BOTON EDITAR";
        echo "<table>";
    }

    if (isset($_SESSION["mensaje_accion"])) {
        echo "<p>" . $_SESSION["mensaje_accion"] . "</p>";
    }
    ?>
</body>

</html>
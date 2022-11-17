<?php
require "src/bd_config.php";

if(isset($_POST["btnConfirmarBorrar"])){
    //CONECTAMOS CON LA BASE DE DATOS:
    try{
        $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
        mysqli_set_charset($conexion, "utf8");
    }catch(Exception $e){
        die("Imposible conectar. Error nº: " . mysqli_connect_errno() . ". " . mysqli_connect_error());
    }
    //REALIZAMOS CONSULTA: 
    $consulta = "DELETE FROM usuarios WHERE id_usuario= '".$_POST["btnConfirmarBorrar"]."'";

    try{
        $resultado = mysqli_query($conexion, $consulta);
    }catch(Exception $e){

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
        table,
        th,
        td {
            border: 1px solid black;
        }

        table {
            border-collapse: collapse
        }

        td img {
            height: 75px
        }

        .txt_centrado {
            text-align: center;
        }

        .centrar {
            width: 80%;
            margin: 1em auto;
        }

        .enlace {
            border: none;
            background: none;
            text-decoration: underline;
            color: blue;
            cursor: pointer
        }

        .img_listar {
            height: 150px;
        }
    </style>
    <title>Práctica 8</title>
</head>

<body>
    <h1>Práctica 8</h1>
    <?php
    //1. CONECTAR CON LA BASE DE DATOS:
    try {
        $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);

        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        die("Imposible conectar. Error nº: " . mysqli_connect_errno() . ". " . mysqli_connect_error());
    }

    //3. CONTROLAMOS LAS DISTINTAS OPERACIONES CRUD ------------------------------------------------

    if (isset($_POST["btnListar"])) {
        echo "<h2 class='centrar'>Listado del Usuario " . $_POST["btnListar"] . "</h2>";
        $consulta = "select * from usuarios where id_usuario='" . $_POST["btnListar"] . "'";
        try {
            $resultado = mysqli_query($conexion, $consulta);
            echo "<div class='centrar'>";
            if (mysqli_num_rows($resultado) > 0) {
                $datos_usuario = mysqli_fetch_assoc($resultado);

                echo "<p><strong>Nombre: </strong>" . $datos_usuario["nombre"] . "</p>";
                echo "<p><strong>Usuario: </strong>" . $datos_usuario["usuario"] . "</p>";
                echo "<p><strong>DNI: </strong>" . $datos_usuario["dni"] . "</p>";
                echo "<p><strong>Sexo: </strong>" . $datos_usuario["sexo"] . "</p>";
                echo "<img src='img/no_imagen.jpg' alt='Foto de usuario' title='Foto de usuario' class='img_listar'>";
            } else {
                echo "<p>El Usuario seleccionado ya no se encuentra registrado en la BD</p>";
            }
            echo "<form method='post' action='index.php'>";
            echo "<p><button type='submit'>Volver</button></p>";
            echo "</form>";
            echo "</div>";
            mysqli_free_result($resultado);
        } catch (Exception $e) {
            $mensaje = "<p>Imposible realizar la consulta. Error Nº " . mysqli_errno($conexion) . " : " . mysqli_error($conexion) . "</p>";
            mysqli_close($conexion);
            die($mensaje);
        }
    } elseif (isset($_POST["btnBorrar"])) {
        echo "<div class='centrar'>";
        echo "<h3>Borrado del usuario con ID: ".$_POST["btnBorrar"]."</h3>";
        echo "¿Está seguro?";
        echo "<form action='index.php' method='post'>";
        echo "<p>";
        echo "<button>Volver</button> &nbsp;";
        echo "<button type='submit' name='btnConfirmarBorrar' value='".$_POST["btnBorrar"]."'>Borrar</button>";
        echo "</p>";
        echo "</form>";
        echo "</div>";
    }elseif (isset($_POST["btnEditar"])){
        echo "editamos usuario ".$_POST["btnEditar"];
    }

    //------------------------------------------------------------------------------------------------
    //2. CONSULTAR LOS DATOS Y PINTAR LA TABLA.
    try {
        $consulta = "SELECT * FROM usuarios";

        $resultado = mysqli_query($conexion, $consulta);

        echo "<h3 class='centrar'>Listado de usuarios</h3>";
        echo "<table class='txt_centrado centrar'>";
        echo "<tr><th>#</th><th>Foto</th><th>Nombre</th><th>Usuario+</th></tr>";
        while ($tupla = mysqli_fetch_assoc($resultado)) {
            echo "<tr>";
            echo "<td>" . $tupla["id_usuario"] . "</td>";
            echo "<td><img src='img/" . $tupla["foto"] . "' title='Foto de perfil' alt='Foto de perfil'></td>";
            echo "<td><form method='post' action='index.php'><button class='enlace' name='btnListar' value='" . $tupla["id_usuario"] . "'>" . $tupla["nombre"] . "</button></form></td>";
            echo "<td><form method='post' action='index.php'><button class='enlace' name='btnBorrar' value='" . $tupla["id_usuario"] . "'>Borrar</button>&nbsp;-&nbsp;<button class='enlace' name='btnEditar' value='" . $tupla["id_usuario"] . "'>Editar</button></form></td>";
            echo "</tr>";
        }

        echo "</table>";

        mysqli_free_result($resultado);
        mysqli_close($conexion);
    } catch (Exception $e) {
        $mensaje = "Imposible realizar la consulta. Error nº: " . mysqli_errno($conexion) . ". " . mysqli_error($conexion);
        mysqli_close($conexion);
        die($mensaje);
    }
    ?>

</body>

</html>